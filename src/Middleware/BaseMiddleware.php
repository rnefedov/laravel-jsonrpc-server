<?php

namespace Nbz4live\JsonRpc\Server\Middleware;

use Nbz4live\JsonRpc\Server\Exceptions\JsonRpcException;
use Nbz4live\JsonRpc\Server\JsonRpcRequest;

interface BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param JsonRpcRequest $request
     * @return mixed
     * @throws JsonRpcException
     */
    public function handle($request);
}