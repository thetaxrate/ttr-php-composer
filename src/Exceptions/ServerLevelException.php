<?php

namespace TheTaxRate\Exceptions;

use Psr\Http\Client\ClientExceptionInterface;

class ServerLevelException  extends \Exception implements ClientExceptionInterface
{

}