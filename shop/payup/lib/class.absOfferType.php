<?php

namespace PayUp\Type;

use PayUp\Type;

abstract class  absOfferType
{

    protected $elements = [];
    protected $mapping = [];

    public function __construct($element, $param = [])
    {
        $this->elements = $element;
        //
        $keys = array_keys($this->elements);
        $this->mapping = array_change_key_case(array_combine($keys, $keys), CASE_LOWER);
        //
        if (empty($param) !== true) {
            $data = array_change_key_case($param, CASE_LOWER);

            foreach ($data as $key => $val) {
                if (!($prop = $this->mapping[$key])) continue;
                $this->elements[$prop] = $val;
            }
        }
    }

    // -------------------------------------------------------------------------

    public function toArray()
    {
        return array_combine(array_keys($this->elements), array_values($this->elements));
    }

    // -------------------------------------------------------------------------

    /**
     * @param $callName
     * @param $arguments
     * @return $this|mixed
     * @throws \Exception
     */
    public function __call($callName, $arguments)
    {
        $method = strtolower($callName);
        if (method_exists($this, $method) === false) {
            // if Class::method does not exist.

            // -- if Set* or Get*
            if (preg_match('/^(set|get)(.*)/i', strtolower($method), $matches) && isset($this->mapping[$matches[2]]) === true) {
                $prop = $this->mapping[$matches[2]];

                switch ($matches[1]) {
                    case 'set':
                        {
                            $this->elements[$prop] = reset($arguments);
                            return $this;
                        }
                    case 'get' :
                        {
                            $value = &$this->elements[$prop];
                            foreach ($arguments as $arg) $value = &$value[$arg];
                            return $value;
                        }
                }
            } // -- end of if
            throw new \Exception('Method ' . $method . ' not exists');
        }
    }

}