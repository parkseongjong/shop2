<?php

namespace PayUp\Type;

use PayUp\Type;

require_once __DIR__ . '/class.absOfferType.php';

/**
 * Class PayUpOfferType
 * @method $this setOrderNumber(string $orderNo)
 * @method string getOrderNumber()
 * @method $this setAmount(int $amount)
 * @method int getAmount()
 * @method $this setItemName(string $itemName)
 * @method string getItemName()
 *
 * @method $this setUserName(string $userName)
 * @method string getUserName()
 * @method $this setUserEmail(string $userEmail)
 * @method string getUserEmail()
 * @method $this setMobileNumber(string $mobileNumber)
 * @method string getMobileNumber()
 *
 * @method $this setBankCode(string $bankCode)
 * @method string getBankCode()
 * @method $this setDepositName(string $depositName)
 * @method string getDepositName()
 *
 * @method $this setCashUseFlag(string $cashUseFlag)
 * @method string getCashUseFlag()
 * @method $this setCashType(string $cashType)
 * @method string getCashType()
 * @method $this setCashNo(string $cashNo)
 * @method string getCashNo()
 * ---
 * @method $this setSignature(string $signature)
 * @method string getSignature()
 *
 * @method $this setTimestamp(string $timestamp)
 * @method string getTimestamp()
 */
class OfferBankType extends absOfferType
{

    public function __construct($param = [])
    {
        return parent::__construct([
            'orderNumber' => ''
            , 'amount' => 0
            , 'itemName' => ''
            , 'userName' => ''
            , 'userEmail' => ''
            , 'mobileNumber' => ''
            , 'bankCode' => ''
            , 'depositName' => ''
            , 'cashUseFlag' => '0'
            , 'cashType' => ''
            , 'cashNo' => ''
            , 'signature' => ''
            , 'timestamp' => ''
        ], $param);
    }
}
