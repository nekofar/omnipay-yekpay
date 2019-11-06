<?php

/**
 * @package Omnipay\Yekpay
 * @author Milad Nekofar <milad@nekofar.com>
 */

namespace Omnipay\Yekpay\Message;

use Exception;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Class AbstractRequest
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * Sandbox Endpoint URL
     *
     * @var string URL
     */
    protected $testEndpoint = 'https://gate.yekpay.com/api/payment';

    /**
     * Live Endpoint URL
     *
     * @var string URL
     */
    protected $liveEndpoint = 'https://gate.yekpay.com/api/payment';

    /**
     * @return string
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    /**
     * @param string $value
     * @return AbstractRequest
     */
    public function setMerchantId(string $value)
    {
        return $this->setParameter('merchantId', $value);
    }

    /**
     * Get the first name of your customer
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->getParameter('billingFirstName');
    }

    /**
     * Set the first name of your customer
     *
     * @param string $value
     * @return $this
     */
    public function setFirstName($value)
    {

        return $this->setParameter('billingFirstName', $value);
    }

    /**
     * Get the last name of your customer
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->getParameter('billingLastName');
    }

    /**
     * Set the last name of your customer
     *
     * @param string $value
     * @return $this
     */
    public function setLastName($value)
    {

        return $this->setParameter('billingLastName', $value);
    }

    /**
     * Get the billing address of your customer
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->getParameter('billingAddress1');
    }

    /**
     * Set the billing address of your customer
     *
     * @param string $value
     * @return $this
     */
    public function setAddress($value)
    {

        return $this->setParameter('billingAddress1', $value);
    }

    /**
     * Get the billing email of your customer
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->getParameter('email');
    }

    /**
     * Set the billing email of your customer
     *
     * @param string $value
     * @return $this
     */
    public function setEmail($value)
    {
        return $this->setParameter('email', $value);
    }

    /**
     * Get the billing mobile of your customer
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->getParameter('billingPhone');
    }

    /**
     * Set the billing mobile of your customer
     *
     * @param string $value
     * @return $this
     */
    public function setMobile($value)
    {
        return $this->setParameter('billingPhone', $value);
    }

    /**
     * Get the billing postal code of your customer
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->getParameter('billingPostcode');
    }

    /**
     * Set the billing postal code of your customer
     *
     * @param string $value
     * @return $this
     */
    public function setPostalCode($value)
    {
        return $this->setParameter('billingPostcode', $value);
    }

    /**
     * Get the billing country of your customer
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->getParameter('billingCountry');
    }

    /**
     * Set the billing country of your customer
     *
     * @param string $value
     * @return $this
     */
    public function setCountry($value)
    {
        return $this->setParameter('billingCountry', $value);
    }

    /**
     * Get the billing city of your customer
     *
     * @return string
     */
    public function getCity()
    {
        return $this->getParameter('billingCity');
    }

    /**
     * Set the billing country of your customer
     *
     * @param string $value
     * @return $this
     */
    public function setCity($value)
    {
        return $this->setParameter('billingCity', $value);
    }

    /**
     * @return string
     */
    public function getAuthority()
    {
        return $this->getParameter('authority');
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setAuthority(string $value)
    {
        return $this->setParameter('authority', $value);
    }

    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send.
     * @return ResponseInterface
     * @throws InvalidResponseException
     */
    public function sendData($data)
    {
        try {
            $httpResponse = $this->httpClient->request(
                'POST',
                $this->createUri($this->getEndpoint()),
                [
                    'Accept' => 'application/json',
                    'Content-type' => 'application/json',
                ],
                json_encode($data)
            );
            $json = $httpResponse->getBody()->getContents();
            $data = !empty($json) ? json_decode($json, true) : [];
            return $this->response = $this->createResponse($data);
        } catch (Exception $e) {
            throw new InvalidResponseException(
                'Error communicating with payment gateway: ' . $e->getMessage(),
                $e->getCode()
            );
        }
    }

    /**
     * @param string $endpoint
     * @return string
     */
    abstract protected function createUri(string $endpoint);

    /**
     * @return string
     */
    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    /**
     * @param array $data
     * @return AbstractResponse
     */
    abstract protected function createResponse(array $data);
}
