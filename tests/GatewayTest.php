<?php

namespace Omnipay\Yekpay\Tests;

use Omnipay\Tests\GatewayTestCase;
use Omnipay\Yekpay\Gateway;
use Omnipay\Yekpay\Message\AbstractResponse;
use Omnipay\Yekpay\Message\PurchaseCompleteResponse;
use Omnipay\Yekpay\Message\PurchaseResponse;

class GatewayTest extends GatewayTestCase
{
    /**
     * @var Gateway
     */
    protected $gateway;

    /**
     * @var array
     */
    protected $options;

    protected function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        $this->gateway->setMerchantId('XXXXXXXXXXXXXXXXXXXX');
        $this->gateway->setReturnUrl('https://example.com/callback.php');

        $this->options = [
            'amount' => 799.00,
            'fromCurrencyCode' => 978,
            'toCurrencyCode' => 364,
            'orderNumber' => 125548,
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'test@example.com',
            'mobile' => '+44123456789',
            'address' => 'Alhamida st Al ras st',
            'postalCode' => '64785',
            'country' => 'United Arab Emirates',
            'city' => 'Dubai',
            'description' => 'Apple mac book air 2017',
        ];
    }

    /**
     *
     */
    public function testPurchaseSuccess()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');

        /** @var PurchaseResponse $response */
        $response = $this->gateway->purchase($this->options)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertEquals('https://gate.yekpay.com/api/payment/start/115162456765', $response->getRedirectUrl());
    }

    /**
     *
     */
    public function testPurchaseFailure()
    {
        $this->setMockHttpResponse('PurchaseFailure.txt');

        /** @var PurchaseResponse $response */
        $response = $this->gateway->purchase($this->options)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('Merchant code is incorrect', $response->getMessage());
    }

    /**
     *
     */
    public function testCompletePurchaseSuccess()
    {
        $this->setMockHttpResponse('PurchaseCompleteSuccess.txt');

        $this->getHttpRequest()->request->replace([
            'authority' => '115162456765',
        ]);

        /** @var PurchaseCompleteResponse $response */
        $response = $this->gateway->completePurchase([
            'authority' => '115162456765',
        ])->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('XXXXXXXXXXXX', $response->getTransactionReference());
    }

    /**
     *
     */
    public function testCompletePurchaseFailure()
    {
        $this->setMockHttpResponse('PurchaseCompleteFailure.txt');

        $this->getHttpRequest()->request->replace([
            'authority' => '115162456765',
        ]);

        /** @var PurchaseCompleteResponse $response */
        $response = $this->gateway->completePurchase([
            'authority' => '115162456765',
        ])->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertSame('Merchant code is incorrect', $response->getMessage());
    }
}
