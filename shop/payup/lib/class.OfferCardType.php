<?php

namespace PayUp\Type;

use PayUp\Type;

require_once __DIR__ . '/class.absOfferType.php';


/**
 * Class PayUpOfferType
 * @method $this setOrderNumber(string $orderNo)
 * @method string getOrderNumber()
 * @method $this setAmount(int $amount)
 * @method string getAmount()
 * @method $this setItemName(string $itemName)
 * @method string getItemName()
 * @method $this setUserName(string $userName)
 * @method string getUserName()
 * @method $this setUserEmail(string $userEmail)
 * @method string getUserEmail()
 * @method $this setMobileNumber(string $mobileNumber)
 * @method string getMobileNumber()
 *
 * @method $this setCardNo(string $cardNo)
 * @method string getCardNo()
 * @method $this setExpireMonth(string $expireMonth)
 * @method string getExpireMonth()
 * @method $this setExpireYear(string $expireYear)
 * @method string getExpireYear()
 * @method $this setCardPw(string $cardPw)
 * @method string getCardPw()
 * @method $this setBirthday(string $birthday)
 * @method string getBirthday()
 * @method $this setQuota(string $quota)
 * @method string getQuota()
 *
 * @method $this setSignature(string $signature)
 * @method string getSignature()
 * @method $this setTimestamp(string $timestamp)
 * @method string getTimestamp()
 */
class OfferCardType extends absOfferType
{
    public function __construct($param = [])
    {
        return parent::__construct([
            'orderNumber' => ''
            , 'amount' => '0'
            , 'itemName' => ''
            , 'userName' => ''
            , 'userEmail' => ''
            , 'mobileNumber' => ''

            , 'cardNo' => ''
            , 'expireMonth' => ''
            , 'expireYear' => '0'
            , 'cardPw' => ''
            , 'birthday' => ''
            , 'quota' => ''

            , 'signature' => ''
            , 'timestamp' => ''
        ], $param);
    }
}
