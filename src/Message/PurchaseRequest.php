<?php

/**
 * @package Omnipay\Yekpay
 * @author Milad Nekofar <milad@nekofar.com>
 */

namespace Omnipay\Yekpay\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Class PurchaseRequest
 */
class PurchaseRequest extends AbstractRequest
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
        $this->validate(
            'merchantId',
            'amount',
            'orderNumber',
            'fromCurrencyCode',
            'toCurrencyCode',
            'returnUrl',
            'billingFirstName',
            'billingLastName',
            'email',
            'billingPhone',
            'billingAddress1',
            'billingPostcode',
            'billingCountry',
            'billingCity',
            'description'
        );

        return [
            'merchantID' => $this->getMerchantId(),
            'amount' => $this->getAmount(),
            'fromCurrencyCode' => $this->getFromCurrencyCode(),
            'toCurrencyCode' => $this->getToCurrencyCode(),
            'orderNumber' => $this->getOrderNumber(),
            'callback' => $this->getReturnUrl(),
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'email' => $this->getEmail(),
            'mobile' => $this->getMobile(),
            'address' => $this->getAddress(),
            'postalCode' => $this->getPostalCode(),
            'country' => $this->getCountry(),
            'city' => $this->getCity(),
            'description' => $this->getDescription(),
        ];
    }

    /**
     * @param string $endpoint
     * @return string
     */
    protected function createUri(string $endpoint)
    {
        return $endpoint . '/PaymentRequest.json';
    }

    /**
     * @param array $data
     * @return PurchaseResponse
     */
    protected function createResponse(array $data)
    {
        return new PurchaseResponse($this, $data);
    }
}
