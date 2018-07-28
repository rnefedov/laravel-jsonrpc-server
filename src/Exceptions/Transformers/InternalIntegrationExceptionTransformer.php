<?php

namespace Nbz4live\JsonRpc\Server\Exceptions\Transformers;

use Nbz4live\JsonRpc\Server\Exceptions\JsonRpcException;
use Nbz4live\JsonRpc\Server\Contracts\ExceptionTransformer;

class InternalIntegrationExceptionTransformer extends AbstractJsonRpcExceptionTransformer
{
    protected static function getErrorCode(): int
    {
        return JsonRpcException::CODE_EXTERNAL_INTEGRATION_ERROR;
    }
}
