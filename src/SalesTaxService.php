<?php

namespace TheTaxRate\SalesTaxProvider;

use GuzzleHttp\Client;
use TheTaxRate\SalesTaxProvider\Response\TaxRateResponse;

final class SalesTaxService
{
    private $_apiToken;

    private $_version = 'v1';

    private $_apiPath = '/api/external/%s/tax_rate/';

    private $_baseUrl = 'https://www.thetaxrate.com';


    /**
     * Token for communication with the API
     * @param $apiToken
     */
    public function __construct($apiToken)
    {
        $this->_apiToken = $apiToken;
        $this->_apiPath = sprintf($this->_apiPath,$this->_version);
    }

    /**
     * Get sale tax response for zip code
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTaxRate($zipCode)
    {
        $response = $this->sendTaxRateRequest($zipCode);
        if(in_array($response->getStatusCode(),[200,201]))
        {
            return new TaxRateResponse($response->getBody()->getContents());
        }
        return new TaxRateResponse();
    }

    /**
     * Send Request for rate to the API
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function sendTaxRateRequest($zipCode)
    {
        return $this->getHttpClient()
            ->request('GET', $this->_baseUrl.$this->_apiPath.$zipCode, [
            'headers' => $this->getRequestHeaders()
        ]);
    }


    /**
     * Create Http client
     * @return Client
     */
    private function getHttpClient()
    {
        return new Client();
    }

    /**
     * Create header values
     * @return string[]
     */
    private function getRequestHeaders()
    {
        return [
            'Authorization' => 'Bearer ' . $this->_apiToken,
            'Accept'        => 'application/json',
        ];
    }

}