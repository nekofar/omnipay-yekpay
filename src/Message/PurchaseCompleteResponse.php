<?php

/**
 * @package Omnipay\Yekpay
 * @author Milad Nekofar <milad@nekofar.com>
 */

namespace Omnipay\Yekpay\Message;

/**
 * Class PurchaseCompleteResponse
 */
class PurchaseCompleteResponse extends AbstractResponse
{
    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->getCode() === 100;
    }

    /**
     * Gateway Reference
     *
     * @return null|string A reference provided by the gateway to represent this transaction
     */
    public function getTransactionReference()
    {
        return $this->data['Reference'];
    }
}
