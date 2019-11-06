<?php

/**
 * @package Omnipay\Yekpay
 * @author Milad Nekofar <milad@nekofar.com>
 */

namespace Omnipay\Yekpay\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Class PurchaseCompleteRequest
 */
class PurchaseCompleteRequest extends AbstractRequest
{
    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     * @throws InvalidRequestException
     */
    public function getData()
    {
        // Validate required parameters before return data
        $this->validate('merchantId', 'authority');

        return [
            'merchantID' => $this->getMerchantId(),
            'authority' => $this->getAuthority(),
        ];
    }

    /**
     * @param string $endpoint
     * @return string
     */
    protected function createUri(string $endpoint)
    {
        return $endpoint . '/PaymentVerification.json';
    }

    /**
     * @param array $data
     * @return PurchaseCompleteResponse
     */
    protected function createResponse(array $data)
    {
        return new PurchaseCompleteResponse($this, $data);
    }
}
