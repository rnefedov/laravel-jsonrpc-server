<?php

namespace Nbz4live\JsonRpc\Server\Middleware;

use Nbz4live\JsonRpc\Server\Exceptions\JsonRpcException;
use Nbz4live\JsonRpc\Server\JsonRpcRequest;

class ValidateJsonRpcMiddleware implements BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  JsonRpcRequest $request
     *
     * @return mixed
     * @throws JsonRpcException
     */
    public function handle($request)
    {
        if (empty($request->call->jsonrpc) || $request->call->jsonrpc !== '2.0' || empty($request->call->method)) {
            throw new JsonRpcException(JsonRpcException::CODE_INVALID_REQUEST);
        }

        return true;
    }
}
