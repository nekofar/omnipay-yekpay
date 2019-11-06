<?php

/**
 * @package Omnipay\Yekpay
 * @author Milad Nekofar <milad@nekofar.com>
 */

namespace Omnipay\Yekpay\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Class PurchaseResponse
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * Sandbox Endpoint URL
     *
     * @var string URL
     */
    protected $testEndpoint = 'https://gate.yekpay.com/api/payment/start/';
    /**
     * Live Endpoint URL
     *
     * @var string URL
     */
    protected $liveEndpoint = 'https://gate.yekpay.com/api/payment/start/';

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return false;
    }

    /**
     * Does the response require a redirect?
     *
     * @return boolean
     */
    public function isRedirect()
    {
        return isset($this->data['Authority']) && !empty($this->data['Authority']);
    }

    /**
     * Gets the redirect target url.
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->getEndpoint() . $this->data['Authority'];
    }

    /**
     * @return string
     */
    protected function getEndpoint()
    {
        return $this->request->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }
}
