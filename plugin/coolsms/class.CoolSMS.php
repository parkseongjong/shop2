<?php
require_once __DIR__ . '/class.client.php';

// ------------------------------------------------------------------------

if (!function_exists('throw_exception')) :
    /**
     * @param string $message
     * @param int $code
     * @param \Throwable|NULL $previous
     * @throws \Exception
     */
    function throw_exception($message = "", $code = 0, \Throwable $previous = null)
    {
        throw new \Exception($message, $code, $previous);
    }

endif;

// TODO: PHP SDK version up 되는 경우 해당 값 변경해야 함
!defined('COOLSMS_SDK_VERSION') && define('COOLSMS_SDK_VERSION', 'php/4.0.1');
!defined('COOLSMS_PLATFORM') && define('COOLSMS_PLATFORM', PHP_OS . ' | ' . phpversion());

/**
 * Class CoolSMS
 * @method Coolsms\Client setHttps(bool $value)
 * @method boolean getHttps()
 * @method Coolsms\Client setHeaders(string $value, $name = null)
 * @method Coolsms\Client setApiKey(string $key)
 * @method string  getApiKey()
 * @method Coolsms\Client setApiSecret(string $key)
 * @method string getApiSecret()
 * @method Coolsms\HTTPResponse|\Exception call(string $endpoint, array | string $message, string $method = 'POST')
 */
class CoolSMS
{
    private $client;
    private $from;

    public function __construct($api_key = '', $api_secret = '')
    {
        $conf = [];
        empty($api_key) !== true && ($conf['apikey'] = $api_key);
        empty($api_secret) !== true && ($conf['secret'] = $api_secret);

        $this->client = new \Coolsms\Client($conf);
    }

    // --------------------------------------------------------------------

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws Exception
     */
    final public function __call($name, $arguments)
    {
        if (method_exists($this, $name) !== false) {
            return call_user_func_array([$this, $name], $arguments);
        }
        else if (method_exists($this->client, $name) !== false) {
            return call_user_func_array([$this->client, $name], $arguments);
        }
        throw new \Exception('Method ' . $name . ' not exists');

    }

    // --------------------------------------------------------------------

    /**
     * @return \Coolsms\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    // --------------------------------------------------------------------

    /**
     * 발신번호
     * @param $value
     * @return $this
     */
    public function setFrom($value)
    {
        $this->from = str_replace('-', '', $value);
        return $this;
    }

    public function getFrom()
    {
        return $this->from;
    }

    // --------------------------------------------------------------------

    /**
     * 수신번호에 단일 SMS 전송(한글 45, 영문 90)
     * @param array|string $to
     * @param string $message 메시지 내용
     */
    public function sms($to, string $message)
    {
        $params = [
            'agent' => [
                'sdkVersion' => COOLSMS_SDK_VERSION
                , 'osPlatform' => COOLSMS_PLATFORM

            ]
            , 'messages' => []
        ];


        is_string($to) === true && ($to = explode(',', $to));

        foreach ($to as $mobile) {
            $params['messages'][] = [
                'type' => 'SMS'
                , 'to' => str_replace('-', '', trim($mobile))
                , 'from' => $this->from
                , 'text' => $message

            ];
        }

        $response = $this->client->call('/messages/v4/send-many', $params);
    }


    // --------------------------------------------------------------------

    /**
     * 수신번호에 단일 SMS 전송(한글 45, 영문 90)
     *
     * @param CoolSMSMessageType $messageType
     * @return array|null
     */
    public function single(CoolSMSMessageType $messageType)
    {
        !$messageType->from() && $messageType->from($this->from);

        $params = [
            'agent' => [
                'sdkVersion' => COOLSMS_SDK_VERSION
                , 'osPlatform' => COOLSMS_PLATFORM
            ],
            'message' => $messageType->toArray()
        ];

        $response = $this->client->call('/messages/v4/send', $params);
        if ($response instanceof \Exception) {
            return ['errorCode' => $response->getCode(), 'errorMessage' => $response->getMessage()];
        }

        return $response->toArray();
    }

    // --------------------------------------------------------------------

    /**
     * @param CoolSMSMessageType[] $messageTypes
     * @return array|null
     */
    public function multiple($messageTypes)
    {
        $params = [
            'agent' => [
                'sdkVersion' => COOLSMS_SDK_VERSION
                , 'osPlatform' => COOLSMS_PLATFORM

            ]
            , 'messages' => []
        ];

        foreach ($messageTypes as $type) {
            !$type->from() && $type->from($this->from);
            $params['messages'][] = $type->toArray();
        }
        $response = $this->client->call('/messages/v4/send-many', $params);
        if ($response instanceof \Exception) {
            return ['errorCode' => $response->getCode(), 'errorMessage' => $response->getMessage()];
        }
        return $response->toArray();
    }


    // --------------------------------------------------------------------

    public function summary($startDate = null, $endDate = null)
    {
        empty($startDate) === true && ($startDate = (new DateTime('-2 month'))->format('Y-m-01 00:00:00'));


        $startDateTime = new DateTime($startDate);
        $endDateTime = new DateTime($endDate);

        $response = $this->client->call('/messages/v4/statistics', ['startDate' => $startDateTime->format(DateTime::ATOM), 'endDate' => $endDateTime->format(DateTime::ATOM)], 'GET');

        if ($response instanceof \Exception) {
            return ['errorCode' => $response->getCode(), 'errorMessage' => $response->getMessage()];
        }
        return array_merge([
            'term' => [
                'startDate' => $startDateTime,
                'endDate' => $endDateTime
            ]
        ], $response->toArray());


        /*
        $data = new stdClass();
        // 조회 시작 일시(ISO8601 포맷으로 입력)
        $data->startDate = '2021-12-01T00:00:00+09:00';
        // 조회 끝 일시(ISO8601 포맷으로 입력)
        $data->endDate = '2021-12-31T23:59:59+09:00';

        $res = request("GET", "/messages/v4/statistics", $data);

        echo <<<EOT
        서비스 이용 금액: {$res->balance}
        서비스 이용 포인트: {$res->point}
        월 평균 서비스 이용 금액: {$res->monthlyBalanceAvg}
        월 평균 서비스 이용 포인트: {$res->monthlyPointAvg}
        일 평균 서비스 이용 금액: {$res->dailyBalanceAvg}
        일 평균 서비스 이용 포인트: {$res->dailyPointAvg}
        일 평균 전체 건수: {$res->dailyTotalCountAvg}
        일 평균 성공 건수: {$res->dailySuccessedCountAvg}
        일 평균 실패 건수: {$res->dailyFailedCountAvg}

        EOT;
        echo "환급정보: ";
        print_r($res->refund);
        echo "메시지 타입별 전체 건수: ";
        print_r($res->total);
        echo "메시지 타입별 성공 건수: ";
        print_r($res->successed);
        echo "메시지 타입별 실패 건수: ";
        print_r($res->failed);

        echo "월별 통계: ";
        print_r($res->monthPeriod);
        echo "일별 통계: ";
        print_r($res->dayPeriod);
        */

    }

    // --------------------------------------------------------------------

    /**
     * 메시지 전송 결과 내역
     * @param CoolSMSListFilter|null $filter
     * @return array|null
     */
    public function getHistory(CoolSMSListFilter $filter = null)
    {

        $param = $filter ? $filter->toParam() : [];

        $response = $this->client->call('/messages/v4/list', $param, 'GET');

        if ($response instanceof \Exception) {
            return ['errorCode' => $response->getCode(), 'errorMessage' => $response->getMessage()];
        }

        $result = $response->toArray();
        if (empty($result['errorCode']) !== true) return $result;

        $returnValue = [
            'offset' => $result['startKey']
            , 'nextSibling' => $result['nextKey']
            , 'rowCount' => $result['limit']
            , 'message' => []
        ];

        foreach ($result['messageList'] as $message) {
            $returnValue['message'][] = [
                'id' => $message['_id']
                , 'groupId' => $message['groupId']
                , 'type' => $message['type']
                , 'from' => $message['from']
                , 'to' => $message['to']
                , 'text' => $message['text']
                , 'subject' => $message['subject']
                , 'imageId' => $message['imageId']
                , 'countryCode' => $message['country']
                , 'networkCode' => $message['networkCode']
                , 'statusCode' => $message['statusCode']
                , 'statusText' => $message['status']
                , 'retry' => $message['resendCount']
                , 'createdAt' => new DateTime($message['dateCreated'])
                , 'receivedAt' => $message['dateReceived'] ? new DateTime($message['dateReceived']) : null
            ];
        }

        return $returnValue;
    }
}

class CoolSMSMessageType
{
    private $_to;
    private $_from;
    private $_message;
    private $_type = 'SMS';

    public function __construct($mobileNo = '', $message = '', $type = '')
    {
        empty($mobileNo) !== true && ($this->_to = $mobileNo);
        empty($message) !== true && ($this->_message = $message);
        empty($type) !== true && $this->type($type);
    }

    // --------------------------------------------------------------------

    /**
     * 회신번호
     * @param string $phoneNo
     * @return $this
     */
    public function from($phoneNo = null)
    {
        if (empty($phoneNo) === true) return $this->_from;

        $this->_from = $phoneNo;
        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * 수신번호
     * @param string $phoneNo
     * @return $this|string
     */
    public function to($phoneNo = null)
    {
        if (empty($phoneNo) === true) return $this->_to;

        $this->_to = $phoneNo;
        return $this;
    }


    // --------------------------------------------------------------------

    /**
     * @param string $text
     * @return $this|string
     */
    public function message($text = null)
    {
        if (empty($text) === true) return $this->_message;

        $this->_message = $text;
        return $this;
    }

    // --------------------------------------------------------------------

    public function type($type = null)
    {
        if (empty($type) === true) {
            return $this->_type;
        }
        else if (in_array($type, ['SMS', 'LMS']) !== true) {
            return false;
        }
        $this->_type = $type;
        return $this;
    }

    // --------------------------------------------------------------------

    public function toArray()
    {
        return [
            'type' => $this->_type
            , 'to' => str_replace('-', '', trim($this->_to))
            , 'from' => $this->_from
            , 'text' => $this->_message

        ];
    }

}

/**
 * Class CoolSMSListFilter]
 */
class CoolSMSListFilter
{
    const STATUS_FILTER_SUCCESS = 1;   // 발송 성공 건
    const STATUS_FILTER_FAILURE = 2;   // 발송 실패건
    const STATUS_FILTER_UNABLE = 3;    // 발송 불가건

    private $filter = ['limit' => 20];

    // --------------------------------------------------------------------

    /**
     * 가져올 메시지 데이터 수
     * @param int $value
     * @return $this
     */
    public function setRowCount(int $value)
    {
        $this->filter['limit'] = $value;
        return $this;
    }

    public function getRowCount()
    {
        return $this->filter['limit'];
    }

    // --------------------------------------------------------------------

    /**
     *
     * @param string $value
     * @return $this
     */
    public function setOffsetID(string $value)
    {
        $this->filter['startKey'] = $value;
        return $this;
    }

    public function getOffsetID()
    {
        return $this->filter['startKey'];
    }

    // --------------------------------------------------------------------

    /**
     * @param string $startDate
     * @param string $endDate
     * @param bool $updated
     * @return $this
     */
    public function setDateRange(string $startDate, $endDate = '', $updated = false)
    {
        $this->filter['startDate'] = (new DateTime($startDate))->format(DateTime::ATOM);
        $this->filter['endDate'] = (new DateTime($endDate))->format(DateTime::ATOM);
        $this->filter['dateType'] = $updated !== false ? 'UPDATED' : 'CREATED';
        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * @return array
     */
    public function getDateRange()
    {
        return [
            'startDate' => $this->filter['startDate'],
            'endDate' => $this->filter['endDate'],
            'updated' => $this->filter['dateType'] == 'UPDATED'
        ];
    }


    // --------------------------------------------------------------------

    /**
     * @param string $value
     * @return $this
     */
    public function setTo(string $value)
    {
        $this->filter['to'] = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->filter['to'];
    }


    // --------------------------------------------------------------------

    /**
     * @param string $value
     * @return $this
     */
    public function setGroupID(string $value)
    {
        $this->filter['groupId'] = $value;
        return $this;
    }

    public function getGroupID()
    {
        return $this->filter['groupId'];
    }

    // --------------------------------------------------------------------

    /**
     * @param int $value
     * @return $this
     */
    public function setStatus(int $value)
    {
        $this->filter['status'] = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->filter['status'];
    }

    // --------------------------------------------------------------------

    /**
     * @return array
     */
    public function toParam()
    {
        $param = $this->filter;
        unset($param['status']);

        switch ($this->filter['status']) {
            case self::STATUS_FILTER_SUCCESS:
                $param['statusCode'] = '4000';
                break;
            case self::STATUS_FILTER_FAILURE:
                $param['criteria'] = 'statusCode,statusCode';
                $param['value'] = '3000,4000';
                $param['cond'] = 'gt,lt';
                break;
            case self::STATUS_FILTER_UNABLE:
                $param['criteria'] = 'statusCode,statusCode';
                $param['value'] = '2000,3000';
                $param['cond'] = 'ne,lt';
                break;
        }

        return $param;
    }

}


