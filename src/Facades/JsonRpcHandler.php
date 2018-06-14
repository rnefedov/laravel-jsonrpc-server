<?php

namespace Nbz4live\JsonRpc\Server\Facades;

use Illuminate\Support\Facades\Facade;
use Nbz4live\JsonRpc\Server\Exceptions\JsonRpcHandler as Handler;

/**
 * JsonRpcHandler Facade
 * @method static handle(\Exception $e)
 */
class JsonRpcHandler extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Handler::class;
    }
}
