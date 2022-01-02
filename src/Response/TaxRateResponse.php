<?php

namespace TheTaxRate\Response;

class TaxRateResponse
{
    private $_rate = 0;

   public function __construct($data = null)
   {
       if(is_null($data))return;

       $json = json_decode($data,true);
       if(isset($json['rate']))$this->_rate = $json['rate'];
   }

   public function getRate()
   {
       return $this->_rate;
   }
}