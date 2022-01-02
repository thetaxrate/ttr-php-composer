<?php

namespace TheTaxRate\Exceptions;

use Psr\Http\Client\ClientExceptionInterface;

class UnAuthorizedException extends \Exception implements ClientExceptionInterface
{

}