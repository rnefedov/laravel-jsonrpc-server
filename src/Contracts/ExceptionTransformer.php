<?php

namespace Nbz4live\JsonRpc\Server\Contracts;

use Nbz4live\JsonRpc\Server\Exceptions\JsonRpcException;

interface ExceptionTransformer
{
    public static function transform(\Exception $exception): ?JsonRpcException;
}
