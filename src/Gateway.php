<?php
/**
 * @package Omnipay\Yekpay
 * @author Milad Nekofar <milad@nekofar.com>
 */

namespace Omnipay\Yekpay;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Yekpay\Message\PurchaseCompleteRequest;
use Omnipay\Yekpay\Message\PurchaseRequest;

/**
 * Class Gateway
 */
class Gateway extends AbstractGateway
{
    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     * @return string
     */
    public function getName()
    {
        return 'Yekpay';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return [
            'testMode' => false,
            'merchantId' => '',
            'returnUrl' => '',
        ];
    }

    /**
     * @return string
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    /**
     * @return string
     */
    public function getReturnUrl()
    {
        return $this->getParameter('returnUrl');
    }

    /**
     * @param string $value
     * @return Gateway
     */
    public function setMerchantId(string $value)
    {
        return $this->setParameter('merchantId', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setReturnUrl(string $value)
    {
        return $this->setParameter('returnUrl', $value);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function completePurchase(array $parameters = [])
    {
        return $this->createRequest(PurchaseCompleteRequest::class, $parameters);
    }
}
