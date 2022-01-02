<?php

namespace TheTaxRate\Exceptions;

use Psr\Http\Client\ClientExceptionInterface;

class ApiLimitException extends \Exception implements ClientExceptionInterface
{

}
