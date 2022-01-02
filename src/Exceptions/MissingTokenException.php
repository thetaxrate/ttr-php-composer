<?php

namespace TheTaxRate\Exceptions;


class MissingTokenException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if($message == "")$message = sprintf("Api Token is requred");
        parent::__construct($message, $code, $previous);
    }
}