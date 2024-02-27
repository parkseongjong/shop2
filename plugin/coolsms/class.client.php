<?php

namespace Coolsms;

use Coolsms;

class Client
{
    public const HostName = 'api.coolsms.co.kr';
    /**
     * @var bool $https
     * @var string $hostname
     * @var int $timeout
     * @var array $headers
     */
    protected $https = true, $timeout = 10, $headers;
    protected $apikey, $secret;

    // --------------------------------------------------------------------

    /**
     * @param array $params
     */
    function __construct($params = [])
    {
        date_default_timezone_set('Asia/Seoul');

        foreach ($params as $name => $value) {
            $prop = strtolower($name);
            if (property_exists($this, $prop) === false) continue;
            $this->{$prop} = $value;
        }

    }

    // ------------------------------------------------------------------------

    /**
     *
     * @param boolean $value
     * @return $this
     */
    public function setHttps($value)
    {
        $this->https = (bool)$value;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHttps()
    {
        return $this->https;
    }

    // ------------------------------------------------------------------------

    /**
     * @param $value
     * @param null $name
     * @return $this
     */
    public function setHeaders($value, $name = null)
    {
        is_array($value) === true ? $this->headers = $value : $this->headers[$name] = $value;
        return $this;
    }

    /**
     * @param null|string $name
     * @return string
     */
    public function getHeaders($name = null)
    {
        $values = $this->headers;
        if (!is_null($name)) {
            array_change_key_case($values, CASE_LOWER);
            $name = strtolower($name);
            $values = $values[$name];
        }
        return $values;
    }

    // --------------------------------------------------------------------

    /**
     * @param string $key
     * @return $this
     */
    public function setApiKey($key)
    {
        $this->apikey = $key;
        return $this;
    }

    public function getApiKey()
    {
        return $this->apikey;
    }

    // --------------------------------------------------------------------

    /**
     * @param string $key
     * @return $this
     */
    public function setApiSecret($key)
    {
        $this->secret = $key;
        return $this;
    }

    public function getApiSecret()
    {
        return $this->secret;
    }

    // --------------------------------------------------------------------

    protected function getAuthorization()
    {
        $key = $this->apikey;
        $secret = $this->secret;

        $salt = uniqid();
        $dateTime = date('Y-m-d\TH:i:s.Z\Z', time());
        $signature = hash_hmac('sha256', $dateTime . $salt, $secret);
        return "HMAC-SHA256 apiKey={$key}, date={$dateTime}, salt={$salt}, signature={$signature}";
    }

    // --------------------------------------------------------------------

    /**
     * @param $endpoint
     * @param $message
     * @param string $method
     * @return HTTPResponse|\Exception
     */
    public function call($endpoint, $message, $method = 'POST')
    {
        $url = ($this->https ? 'https://' : 'http://') . self::HostName . '/' . ltrim($endpoint, '/');

        $option = [
            'TIMEOUT' => $this->timeout
            , 'CONNECTTIMEOUT' => 5
            , 'HTTP_VERSION' => CURL_HTTP_VERSION_1_1
            , 'FAILONERROR' => false
            , 'FOLLOWLOCATION' => true

            , 'RETURNTRANSFER' => true
            , 'HEADER' => true
            , 'SSL_VERIFYHOST' => false
            , 'SSL_VERIFYPEER' => false
            , 'USERAGENT' => 'DEVPER-HTTPClient/0.1'
            , 'HTTPHEADER' => []
        ];

        //
        //  Parameter handling according to method
        $method = strtoupper($method);
        switch ($method) {
            case 'GET' :
                {
                    is_array($message) && $message = http_build_query($message);

                    empty($message = trim($message)) !== true && ($url .= (strpos($url, '?') === false ? '?' : '&') . $message);
                    $option['HTTPGET'] = true;
                    break;
                }
            case 'POST' :
                {
                    is_array($message) && $message = json_encode($message);

                    $option['POST'] = true;
                    $option['POSTFIELDS'] = trim($message);
                    break;
                }
            case 'PUT' :
            case 'COPY' :
            case 'MOVE' :
            case 'DELETE' :
                {
                    is_array($message) && $message = json_encode($message);

                    $option['CUSTOMREQUEST'] = $method;
                    $option['POSTFIELDS'] = trim($message);
                    break;
                }

        }

        //
        // Header configure
        $headers = [
            'Authorization' => $this->getAuthorization()
            , 'Content-Type' => 'application/json'
        ];

        // -- Merge custom Header
        is_array($this->headers) === true && empty($this->headers) === false && ($headers = array_merge($headers, $this->headers));

        foreach ($headers as $name => $value) {
            $option['HTTPHEADER'][] = is_numeric($name) === true && strpos($value, ':') !== false ? $value : "{$name}: {$value}";
        }


        $params = [];
        foreach ($option as $name => $value) {
            $opt_name = "CURLOPT_{$name}";
            if (!defined($opt_name)) continue;
            $params[constant($opt_name)] = $value;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt_array($ch, $params);

        /** CURL response */
        $response_raw = curl_exec($ch);

        $error_code = curl_errno($ch);
        $error_message = curl_error($ch);
        $curl_info = curl_getinfo($ch);
        curl_close($ch);

        /** CURL Error */
        if ($error_code !== 0) {
            return new \Exception($error_message, $error_code);
        }

        $res = new HTTPResponse();
        $res->setRequestMethod($method);
        $res->setRequestUrl($url);
        $res->setResponseCode($curl_info['http_code']);
        $res->setResponseStatus(HTTPResponse::getResponseState($curl_info['http_code']));

        $row_header = trim(substr($response_raw, 0, $curl_info['header_size']));
        $row_body = trim(substr($response_raw, $curl_info['header_size']));
        $res->setBody($row_body);
        unset($response_raw, $row_body);

        $header_array = preg_split('/\r\n/', $row_header, null, PREG_SPLIT_NO_EMPTY);
        $response_header = [];

        foreach ($header_array as $line) {
            list($name, $value) = explode(':', $line, 2);
            $response_header[$name] = $value;
        }
        return ($res->setHeader($response_header));
    }
}

/**
 * Class HTTPResponse
 * @package Coolsms
 *
 * @method string getBody
 * @method HTTPResponse setBody(string $body)
 *
 * @method string getRequestMethod()
 * @method HTTPResponse setRequestMethod(string $method)
 *
 * @method string getRequestUrl()
 * @method HTTPResponse setRequestUrl(string $anyUrl)
 *
 * @method string getResponseStatus()
 * @method HTTPResponse setResponseStatus(string $status_text)
 *
 * @method number getResponseCode()
 * @method HTTPResponse setResponseCode($code)
 *
 */
class HTTPResponse
{
    protected $_elements;

    protected $body;
    protected $requestmethod;
    protected $requesturl;
    protected $responsestatus;
    protected $responsecode;
    protected $headers;
    protected $result;

    /**
     * @param array $params
     */
    function __construct($params = [])
    {

        foreach ($params as $name => $value) {
            $prop = str_replace('_', '', strtolower($name));
            if (property_exists($this, $prop) === false) continue;
            $this->{$prop} = $value;
        }
    }

    /**
     * @param bool|FALSE $in_null
     * @return string JSON
     */
    public function toString($in_null = false)
    {
        return json_encode($this->stringify($in_null));
    }

    /**
     * @param bool|FALSE $in_null
     * @return string
     */
    public function toQuery($in_null = false)
    {
        return http_build_query($this->stringify($in_null));
    }

    /**
     * @param bool|FALSE $in_null
     * @return array
     */
    public function stringify($in_null = false)
    {
        $propValue = get_object_vars($this);
        $propName = array_keys($propValue);
        $returnValue = [];
        $element = [];

        if (empty($this->_elements) === false) {
            $element = array_change_key_case(array_combine($this->_elements, $this->_elements), CASE_LOWER);
        }

        foreach ($propName as $name) {
            if ($name == '_elements' || ($in_null === false && is_null($propValue[$name]) === true)) {
                continue;
            }

            $rename = empty($element[$name]) === true ? $name : $element[$name];
            $returnValue[$rename] = $propValue[$name];
        }
        return $returnValue;
    }

    /**
     * @param string $callName
     * @param array $args
     * @return $this|mixed|void
     * @throws \Exception
     */
    final public function __call($callName, $args)
    {
        $method = strtolower($callName);

        // if Class::method does not exist.
        if (method_exists($this, $method) === false) {
            // -- if Set* or Get*
            if (preg_match('/^(set|get)(.*)/i', strtolower($method), $matches) && property_exists($this, $matches[2])) {
                $prop = $matches[2];

                switch ($matches[1]) {
                    case 'set':
                        {
                            $value = array_shift($args);

                            $node = &$this->{$prop};
                            foreach ($args as $arg) $node = &$node[$arg];
                            $node = $value;

                            // foreach($args as $arg) $prop .= '[' . $arg . ']';
                            //eval("\$this->{$prop} = \$value;");
                            return $this;
                        }
                    case 'get' :
                        {
                            foreach ($args as $arg) $prop .= '[' . $arg . ']';

                            return $this->{$prop};
                        }
                }
            } // -- end of if

            throw new \Exception('Method ' . $method . ' not exists');
        }
    }

    /**
     * @param string [$header]
     * @return array
     */
    public function getHeader($header = null)
    {
        return isset($header) === true ? $this->headers[$header] : $this->headers;
    }

    /**
     * @param array|string $value
     * @param null $header
     * @return HTTPResponse
     */
    public function setHeader($value, $header = null)
    {
        is_array($value) === true ? $this->headers = $value : $this->headers[$header] = $value;
        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * @return array|null
     */
    public function toArray() {
        if (isset($this->result) !== true) {
            $result = null;
            if (empty($this->body) !== true) {
                $result = json_decode($this->body, true);
                json_last_error() !== JSON_ERROR_NONE && ( $result = ['errorCode'=>'ParserError', 'errorMessage'=>json_last_error_msg()] );
            }
            $this->result = $result;
        }
        return $this->result;
    }

    // ------------------------------------------------------------------------

    /**
     * HTTP Status Text
     * @param string $code
     * @return mixed
     */
    public static function getResponseState($code)
    {
        $text = array(
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',

            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            307 => 'Temporary Redirect',

            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',

            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported'
        );
        return $text[$code];
    }
}
