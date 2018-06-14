<?php

namespace Nbz4live\JsonRpc\Server\Middleware;

use Illuminate\Support\Facades\Request;
use Nbz4live\JsonRpc\Server\Exceptions\JsonRpcException;
use Nbz4live\JsonRpc\Server\JsonRpcRequest;

class ServiceValidationMiddleware implements BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param JsonRpcRequest $request
     *
     * @return mixed
     * @throws JsonRpcException
     */
    public function handle($request)
    {
        $allow_ips = config('jsonrpc.servers.' . $request->service);

        // если не заданы настройки - по умолчанию запрещаем доступ
        if (null === $allow_ips) {
            throw new JsonRpcException(JsonRpcException::CODE_FORBIDDEN);
        }

        // если разрешено всем
        if ($allow_ips === '*') {
            return true;
        }

        if (!\is_array($allow_ips)) {
            throw new JsonRpcException(JsonRpcException::CODE_FORBIDDEN);
        }

        // если разрешено всем
        if (\in_array('*', $allow_ips, true)) {
            return true;
        }

        $ip = Request::ip();
        if (!\in_array($ip, $allow_ips, true)) {
            throw new JsonRpcException(JsonRpcException::CODE_FORBIDDEN);
        }

        return true;
    }
}
