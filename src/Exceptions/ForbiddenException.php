<?php

namespace TheTaxRate\Exceptions;

use Psr\Http\Client\ClientExceptionInterface;

class ForbiddenException  extends \Exception implements ClientExceptionInterface
{
}