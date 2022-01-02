<?php

namespace TheTaxRate\Exceptions;

class MissingZipCodeException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if($message == "")$message = sprintf("ZipCode is requred");
        parent::__construct($message, $code, $previous);
    }
}