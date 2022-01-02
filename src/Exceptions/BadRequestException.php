<?php

namespace TheTaxRate\Exceptions;

use Psr\Http\Client\ClientExceptionInterface;

class BadRequestException  extends \Exception implements ClientExceptionInterface
{

}