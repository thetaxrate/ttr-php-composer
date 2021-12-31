<?php

namespace TheTaxRate\SalesTaxProvider;

use GuzzleHttp\Client;
use TheTaxRate\SalesTaxProvider\Response\TaxRateResponse;

class SalesTaxService
{
    private $_apiToken;


    private $_baseUrl = 'www.thetaxrate.com/external/v1/tax_rate/%s';

    private $_version = 'v1';

    private $_apiPath = '/external/%s/tax_rate/';


    public function __construct($apiToken)
    {
        $this->_apiToken = $apiToken;
        $this->_apiPath = sprintf($this->_apiPath,$this->_version);
    }

    public function getTaxRate($zipCode)
    {
        $response = $this->sendTaxRateRequest($zipCode);
        if($response->getStatusCode() == 200 ||
            $response->getStatusCode() == 201)
        {
            return new TaxRateResponse($response->getBody()->getContents());
        }
        return new TaxRateResponse();
    }

    private function sendTaxRateRequest($zipCode)
    {
        return $this->getHttpClient()->request('GET', $this->_apiPath.$zipCode, [
            'headers' => $this->getRequestHeaders()
        ]);
    }


    /**
     * @return Client
     */
    private function getHttpClient()
    {
       return new Client(['base_uri' => $this->_baseUrl]);
    }

    private function getRequestHeaders()
    {
        return [
            'Authorization' => 'Bearer ' . $this->_apiToken,
            'Accept'        => 'application/json',
        ];
    }

}