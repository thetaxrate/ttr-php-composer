<?php

namespace TheTaxRate;


use GuzzleHttp\Client;
use TheTaxRate\Exceptions\ApiLimitException;
use TheTaxRate\Exceptions\BadRequestException;
use TheTaxRate\Exceptions\ForbiddenException;
use TheTaxRate\Exceptions\MissingTokenException;
use TheTaxRate\Exceptions\MissingZipCodeException;
use TheTaxRate\Exceptions\ServerLevelException;
use TheTaxRate\Exceptions\UnAuthorizedException;
use TheTaxRate\Response\TaxRateResponse;

final class SalesTaxService
{
    private $_apiToken;

    private $_version = 'v1';

    private $_apiPath = '/api/external/%s/tax_rate/';

    private $_baseUrl = 'https://www.thetaxrate.com';


    /**
     * Token for communication with the API
     * @param $apiToken
     * @throws MissingTokenException
     */
    public function __construct($apiToken)
    {
        if(is_null($apiToken))throw new MissingTokenException();
        $this->_apiToken = $apiToken;
        $this->_apiPath = sprintf($this->_apiPath,$this->_version);
    }

    /**
     *  Get sale tax response for zip code
     * @param $zipCode
     * @return TaxRateResponse
     * @throws ApiLimitException
     * @throws BadRequestException
     * @throws ForbiddenException
     * @throws MissingZipCodeException
     * @throws ServerLevelException
     * @throws UnAuthorizedException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTaxRate($zipCode)
    : TaxRateResponse
    {
        if(is_null($zipCode))throw new MissingZipCodeException();
        try
        {
            $response = $this->sendTaxRateRequest($zipCode);
            if (in_array($response->getStatusCode(), [200, 201]))
            {
                return new TaxRateResponse($response->getBody()->getContents());
            }
            return new TaxRateResponse();
        }
        catch (\GuzzleHttp\Exception\GuzzleException $ex)
        {
            $this->processException($ex);
            throw $ex;
        }
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

    /**
     * @param $ex
     * @return void
     * @throws ApiLimitException
     * @throws BadRequestException
     * @throws ForbiddenException
     * @throws ServerLevelException
     * @throws UnAuthorizedException
     */
    private function processException($ex)
    : void
    {
        switch ($ex->getCode()) {
            case 400: //Bad Request
                throw new BadRequestException($ex->getMessage());
                break;
            case 401:
                throw new UnAuthorizedException($ex->getMessage());
                break;
            case 429: //To Many
                throw new ApiLimitException($ex->getMessage());
                break;
            case 403: //Forbidden
                throw new ForbiddenException($ex->getMessage());
                break;
            case 500: //Error
                throw new ServerLevelException($ex->getMessage());
                break;
        }
    }

}