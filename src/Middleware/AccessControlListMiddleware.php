<?php

namespace Nbz4live\JsonRpc\Server\Middleware;

use Nbz4live\JsonRpc\Server\Exceptions\JsonRpcException;
use Nbz4live\JsonRpc\Server\JsonRpcRequest;

class AccessControlListMiddleware implements BaseMiddleware
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
        $controller = \get_class($request->controller);
        $method = $request->method;

        $service = $request->service;

        $aclController = $request->options['acl'][$controller] ?? [];
        $aclMethod = $request->options['acl'][$controller . '@' . $method] ?? [];

        // если не заданы настройки - по умолчанию запрещаем доступ
        if (empty($aclController) && empty($aclMethod)) {
            throw new JsonRpcException(JsonRpcException::CODE_FORBIDDEN);
        }

        // если разрешено всем
        if ('*' === $aclController || '*' === $aclMethod) {
            return true;
        }

        if (!\is_array($aclController) || !\is_array($aclMethod)) {
            throw new JsonRpcException(JsonRpcException::CODE_FORBIDDEN);
        }

        // если нашей системы нет в списке разрешенных
        if (!\in_array('*', $aclController, true) && !\in_array($service, $aclController, true) &&
            !\in_array('*', $aclMethod, true) && !\in_array($service, $aclMethod, true)) {
            throw new JsonRpcException(JsonRpcException::CODE_FORBIDDEN);
        }

        return true;
    }
}
