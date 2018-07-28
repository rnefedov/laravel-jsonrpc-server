<?php

namespace Nbz4live\JsonRpc\Server\Exceptions\Transformers;

use Nbz4live\JsonRpc\Server\Exceptions\JsonRpcException;
use Nbz4live\JsonRpc\Server\Contracts\ExceptionTransformer;

abstract class AbstractJsonRpcExceptionTransformer implements ExceptionTransformer
{
    public static function transform(\Exception $exception): ?JsonRpcException
    {
        return new JsonRpcException(static::getErrorCode(), null, null, $exception);
    }

    abstract protected static function getErrorCode(): int;
}
