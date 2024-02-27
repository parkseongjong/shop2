<?php

namespace PayUp;

use PayUp\Type\OfferBankType;
use PayUp\Type\OfferCardType;
use phpbrowscap\Exception;

class PayUp
{
    const DEVE_HOST = 'https://api.testpayup.co.kr';
    const PROD_HOST = 'https://api.payup.co.kr';
    protected const END_POINT = [
        'CHECKOUT' => '/ap/api/payment/{MERCHANT_ID}/order'
        , 'CANCEL' => '/v2/api/payment/{MERCHANT_ID}/cancel2'
        , 'PARTIAL_CANCEL' => '/v2/api/payment/{MERCHANT_ID}/partcancel'
        , 'VBANK' => '/va/api/payment/{MERCHANT_ID}/issue'
        , 'CARD_CHECK' => '/cardBin/binCheck.do'
        , 'CARD_PAYOUT' => '/v2/api/payment/{MERCHANT_ID}/keyin2'
    ];

    public const ERROR = [
        '0000' => 'Success'
        , '1001' => '등록되지 않은 서비스아이디 입니다'
        , '1002' => '제휴사 프로세스 생성 오류'
        , '1003' => '정산 대상 금액 부족으로 취소가 불가 합니다'
        , '1004' => '취소 대상건이 없습니다'
        , '1005' => '취소 가능 상태가 아닙니다'
        , '1006' => '취소 업데이트 오류'
        , '2001' => '전문 검증에러 - 관리자에게 문의 부탁드립니다'
        , '5001' => '결제 금액이 최소 결제 금액 보다 작습니다'
        , '5002' => '결제 금액 이 최대 결제 금액 보다 큽니다'
        , '5003' => '가맹점 일한도 초과 ! 관리자에게 문의 부탁 드립니다'
        , '5004' => '가맹점 월한도 초과 ! 관리자에게 문의 부탁 드립니다'
        , '5005' => '이행보증보험 한도 초과 ! 관리자에게 문의 부탁 드립니다'
        , '6001' => '{파라미터명}은 필수 항목입니다.'
        , '6002' => '{파라미터명}이 잘못되었습니다'
        , '6003' => '파리미터를 확인해주세요'
        , '8001' => '주문 정보가 없습니다'
        , '8002' => '사용자결제 취소'
        , '9001' => '관리자에게 문의해주세요'
    ];

    private $merchant_id;
    private $secret;

    private $vba_merchant;

    private $apikey;
    private $is_test;

    private $dateTime; // Timestamp
    private $returnUrl;
    #private $notiUrl;
    private $auth_return;
    private $bypassValue;
    private $simulator;

    // --------------------------------------------------------------------

    public function __construct($mid = '', $secret = '', $apikey = '')
    {
        empty($mid) !== true && ($this->merchant_id = $mid);
        empty($secret) !== true && ($this->secret = $secret);
        empty($apikey) !== true && ($this->apikey = $apikey);
    }

    // --------------------------------------------------------------------

    /**
     * Api Key
     * @param $value
     * @return $this
     */
    public function setSimulator($value)
    {
        $this->simulator = $value;
        return $this;
    }

    public function getSimulator()
    {
        return $this->simulator;
    }

    // --------------------------------------------------------------------

    /**
     * 가맹점 ID
     * @param $value
     * @return $this
     */
    public function setMerchantId($value)
    {
        $this->merchant_id = $value;
        return $this;
    }

    public function getMerchantId()
    {
        return $this->merchant_id;
    }

    /**
     * 인증키
     * @param $value
     * @return $this
     */
    public function setSecret($value)
    {
        $this->secret = $value;
        return $this;
    }

    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * Api Key
     * @param $value
     * @return $this
     */
    public function setApiKey($value)
    {
        $this->apikey = $value;
        return $this;
    }

    public function getApiKey()
    {
        return $this->apikey;
    }

    // --------------------------------------------------------------------

    /**
     * 가상계좌 - 가맹점 정보
     * @param $merchant_id
     * @param $secret
     * @return $this
     */
    public function setVirtualAccountMerchant($merchant_id, $secret)
    {
        $this->vba_merchant = ['id' => $merchant_id, 'secret' => $secret];
        return $this;
    }

    public function getVirtualAccountMerchant()
    {
        return $this->vba_merchant;
    }

    // --------------------------------------------------------------------

    /**
     * 테스트 결제 설정 또는 결제 여부
     * @param boolean|null $value
     * @return $this|boolean
     */
    public function isTest($value = null)
    {
        if (is_null($value) !== true && is_bool($value) === true) {
            $this->is_test = $value;
            return $this;
        }
        return $this->is_test;
    }

    // --------------------------------------------------------------------

    public function getTimestamp($is_reset = false)
    {
        $is_reset === true && ($this->dateTime = null);
        !$this->dateTime && ($this->dateTime = new \DateTime('now', new \DateTimeZone('Asia/Seoul')));
        return $this->dateTime->format('YmdHis');
    }

    // --------------------------------------------------------------------

    /**
     * 플러그인 방식일 때 JS 경로
     * @return string
     */
    public function getPlugInJavascript()
    {
        return $this->is_test ? self::DEVE_HOST . '/resources/plugin2/testpayup_plugin2.js' : self::PROD_HOST . '/resources/plugin2/payup_plugin2.js';
    }

    // --------------------------------------------------------------------

    /**
     * 플러그인 방식일 때 JS 경로
     * @return string
     */
    public function getHostName()
    {
        return $this->is_test ? self::DEVE_HOST : self::PROD_HOST;
    }

    // --------------------------------------------------------------------

    /**
     * 위변조 방지체크를 signature 생성(merchantId|orderNumber|amount|secretKey|timestamp)
     * @param string $orderId
     * @param  $amount
     * @return bool|string
     */
    public function makeSignature(string $orderId, $amount)
    {
        $timestamp = $this->getTimestamp();
        $stringify = "{$this->merchant_id}|{$orderId}|{$amount}|{$this->secret}|{$timestamp}";
        return hash('sha256', $stringify);
    }

    // --------------------------------------------------------------------

    public function makeVBASignature(string $orderId, $amount)
    {
        $timestamp = $this->getTimestamp();
        $stringify = "{$this->vba_merchant['id']}|{$orderId}|{$amount}|{$this->vba_merchant['secret']}|{$timestamp}";
        return hash('sha256', $stringify);
    }


    // --------------------------------------------------------------------

    /**
     * @param string $url AnyURL
     * @return $this
     */
    public function setReturnUrl($url)
    {
        $this->returnUrl = $url;
        return $this;
    }

    public function getReturnUrl()
    {
        return $this->returnUrl;
    }

    // --------------------------------------------------------------------

    /**
     * @param string $url AnyURL
     * @return $this
     */
    public function setAuthReturn($url)
    {
        $this->auth_return = $url;
        return $this;
    }

    public function getAuthReturn()
    {
        return $this->auth_return;
    }
    // --------------------------------------------------------------------

    /**
     * @param string $url AnyURL
     * @return $this
     */
    public function setBypassValue($url)
    {
        $this->bypassValue = $url;
        return $this;
    }

    public function getBypassValue()
    {
        return $this->bypassValue;
    }

    // --------------------------------------------------------------------

    /**
     * 신용카드 인앱 주문서 생성
     * @param string $orderId 주문번호
     * @param string|int $amount 결제금액
     * @param string $subject 상품명
     * @param string $buyer 구매자명
     * @param string $email 구매자 이메일
     * @param string $device WP: 데스크탑, WM: 모바일
     * @return array
     */
    public function Checkout($orderId, $amount, $subject, $buyer, $email, $device)
    {
        $offer = [
            'orderNumber' => "{$orderId}"
            , 'amount' => "{$amount}"
            , 'itemName' => "{$subject}"
            , 'userName' => "{$buyer}"
            , 'userEmail' => "{$email}"
            , 'timestamp' => $this->getTimestamp(true)
            , 'signature' => $this->makeSignature($orderId, $amount)
            , 'userAgent' => $device
            , 'returnUrl' => $this->returnUrl
            , 'auth_return' => $this->auth_return
            , 'bypassValue' => $this->bypassValue ?? ''
        ];
        $endpoint = str_replace('{MERCHANT_ID}', $this->merchant_id, self::END_POINT['CHECKOUT']);
        return $this->_call($endpoint, $offer);
    }

    // --------------------------------------------------------------------

    /**
     * 인앱결제 승인 확인 요청
     * @param $endPoint
     * @param $token
     * @return array
     */
    public function Authorize($endPoint, $token)
    {
        return $this->_call($endPoint, ['RETURNPARAMS' => $token]);
    }

    // --------------------------------------------------------------------

    /**
     * 부분취소
     * @param $txID
     * @param $partial
     * @param $reason
     * @return array
     */
    public function PartialCancel($txID, $partial, $reason)
    {

        $offer = [
            'transactionId' => "{$txID}"
            , 'cancelAmount' => "{$partial}"
            , 'cancelReason' => "{$reason}"
            , 'signature' => hash('sha256', "{$this->merchant_id}|{$txID}|{$partial}|{$this->secret}")
        ];

        $endpoint = str_replace('{MERCHANT_ID}', $this->merchant_id, self::END_POINT['PARTIAL_CANCEL']);
        return $this->_call($endpoint, $offer);
    }

    // --------------------------------------------------------------------

    /**
     * 결제 승인 취소
     * @param $txID
     * @return array
     */
    public function Cancel($txID)
    {
        $offer = [
            'transactionId' => "{$txID}"
            , 'signature' => hash('sha256', "{$this->merchant_id}|{$txID}|{$this->secret}")
        ];
        $endpoint = str_replace('{MERCHANT_ID}', $this->merchant_id, self::END_POINT['CANCEL']);
        return $this->_call($endpoint, $offer);
    }

    // --------------------------------------------------------------------

    /**
     * 가상계좌 발급
     * @param OfferBankType $offerType 주문번호
     * @return array
     */
    public function VBank(OfferBankType $offerType)
    {
        $timestamp = $this->getTimestamp(true);
        $signature = $this->makeVBASignature($offerType->getOrderNumber(), $offerType->getAmount());

        $offerType->setTimestamp($timestamp);
        $offerType->setSignature($signature);

        if (empty($offerType->getCashNo()) !== true) {
            $offerType->setCashUseFlag('1');
        }
        else {
            $offerType->setCashUseFlag('0');
            $offerType->setCashType('');
            $offerType->setCashNo('');
        }

        $endpoint = str_replace('{MERCHANT_ID}', $this->vba_merchant['id'], self::END_POINT['VBANK']);
        return $this->_call($endpoint, $offerType->toArray());
    }

    // --------------------------------------------------------------------

    /**
     * @param OfferCardType $offerType
     * @return array
     */
    public function Payout(OfferCardType $offerType)
    {

        $timestamp = $this->getTimestamp(true);
        $signature = $this->makeSignature($offerType->getOrderNumber(), $offerType->getAmount());

        $offerType->setTimestamp($timestamp);
        $offerType->setSignature($signature);

        $endpoint = str_replace('{MERCHANT_ID}', $this->merchant_id, self::END_POINT['CARD_PAYOUT']);

        return $this->_call($endpoint, $offerType->toArray());
    }

    // --------------------------------------------------------------------

    /**
     * 카드번호를 통한 카드 정보 가져오기(카드사, 종류, ..)
     * @param string $cardNo
     * @return array|null
     */
    public function cardCheck($cardNo)
    {
        if (strlen($cardNo) < 6) return null;
        return $this->_call(self::END_POINT['CARD_CHECK'], ['cardNo' => $cardNo]);
    }

    // --------------------------------------------------------------------

    protected function _call($endpoint, $message = null)
    {
        if (empty(parse_url($endpoint, PHP_URL_HOST)) === true) {
            $url = ($this->is_test ? self::DEVE_HOST : self::PROD_HOST) . '/' . ltrim($endpoint, '/');
        }
        else {
            $url = $endpoint;
        }

        is_array($message) && $message = json_encode($message, JSON_UNESCAPED_UNICODE);

        if ($this->simulator) {
            $curl_command = 'curl -X POST \\' . PHP_EOL;
            $curl_command .= '-H "Content-Type: application/json; charset=utf-8" \\' . PHP_EOL;
            $curl_command .= '-d "' . addslashes($message) . '" \\' . PHP_EOL . $url;

            ob_end_clean();

            die($curl_command);
        }

        // CURL option
        $default = [
            'TIMEOUT' => 15
            , 'CONNECTTIMEOUT' => 5
            , 'HTTP_VERSION' => CURL_HTTP_VERSION_1_1
            , 'FAILONERROR' => false
            , 'FOLLOWLOCATION' => false
            , 'RETURNTRANSFER' => true
            , 'HEADER' => true
            , 'SSL_VERIFYHOST' => false
            , 'SSL_VERIFYPEER' => false
            , 'USERAGENT' => 'HANSBIOTECH-HTTPClient/0.1'
            , 'HTTPHEADER' => ['Content-Type: application/json; charset=utf-8']
        ];
        $option = [];
        $returnValue = [
            'responseCode' => 'PG-8001'
            , 'responseMsg' => 'internal error'
        ];

        //
        //  Parameter handling according to method

        $default['POST'] = true;
        $default['POSTFIELDS'] = trim($message);

        //
        //
        foreach ($default as $name => $value) {
            $opt_name = "CURLOPT_{$name}";
            if (!defined($opt_name)) continue;
            $option[constant($opt_name)] = $value;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt_array($ch, $option);

        /** CURL response */
        $response_raw = curl_exec($ch);

        $error_code = curl_errno($ch);
        $error_message = curl_error($ch);
        $curl_info = curl_getinfo($ch);
        curl_close($ch);

        /** CURL Error */
        if ($error_code !== 0) {
            $returnValue['responseCode'] = "CURL-{$error_code}";
            $returnValue['responseMsg'] = $error_message;
            return $returnValue;
        }

        $row_body = trim(substr($response_raw, $curl_info['header_size']));
        /*
        $row_header = trim(substr($response_raw, 0, $curl_info['header_size']));
        $header_array = preg_split('/\r\n/', $row_header, null, PREG_SPLIT_NO_EMPTY);
        $response_header = [];
        foreach ($header_array as $line) {
            list($name, $value) = explode(':', $line, 2);
            $response_header[$name] = $value;
        }*/

        unset($response_raw);
        $parse = json_decode($row_body, true);
        if (json_last_error()) {
            $returnValue['responseCode'] = "HTTP-{$curl_info['http_code']}";
            $returnValue['responseMsg'] = 'JSON-ERROR: ' . json_last_error_msg();
        }

        if (isset($parse['code']) === true) {
            $parse['responseCode'] = $parse['code'];
            $parse['responseMsg'] = $parse['msg'];
        }
        unset($parse['http_code'], $parse['code'], $parse['msg']);
        $returnValue = array_merge($returnValue, $parse);
        ##$returnValue['CURL'] = $curl_info;
        ##$returnValue['PARAM'] = $message;
        return $returnValue;
    }
}

