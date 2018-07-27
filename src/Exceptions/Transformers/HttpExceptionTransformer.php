<?php

namespace Nbz4live\JsonRpc\Server\Exceptions\Transformers;

use Nbz4live\JsonRpc\Server\Contracts\ExceptionTransformer;
use Nbz4live\JsonRpc\Server\Exceptions\JsonRpcException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Response;

class HttpExceptionTransformer implements ExceptionTransformer
{
    public static function transform(\Exception $exception): ?JsonRpcException
    {
        if ($exception instanceof HttpException) {
            return null;
        }
        
        $errorCode = $exception->getStatusCode();
        $errorMessage = $exception->getMessage();

        if (empty($errorMessage)) {
            $errorMessage = Response::$statusTexts[$errorCode] ?? 'Unknown error';
        }

        return new JsonRpcException($errorCode, $errorMessage, null, $exception);
    }
}
