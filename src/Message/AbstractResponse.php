<?php

/**
 * @package Omnipay\Yekpay
 * @author Milad Nekofar <milad@nekofar.com>
 */

namespace Omnipay\Yekpay\Message;

/**
 * Class AbstractResponse
 */
abstract class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse
{

    /**
     * @var array
     */
    protected $codes = [
        '-1' => 'The parameters are incomplete',
        '-2' => 'Merchant code is incorrect',
        '-3' => 'Merchant code is not active',
        '-4' => 'Currencies is not valid',
        '-5' => 'Maximum/Minimum amount is not valid',
        '-6' => 'Your IP is restricted',
        '-7' => 'Order id must be unique',
        '-100' => 'Unknown error',
        '100' => 'Success',
    ];

    /**
     * Response Message
     *
     * @return null|string A response message from the payment gateway
     */
    public function getMessage()
    {
        return isset($this->codes[$this->getCode()]) ? $this->codes[$this->getCode()] : parent::getMessage();
    }

    /**
     * Response code
     *
     * @return null|string A response code from the payment gateway
     */
    public function getCode()
    {
        return isset($this->data['Code']) ? $this->data['Code'] : parent::getCode();
    }
}
