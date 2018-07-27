<?php

namespace Nbz4live\JsonRpc\Server\Exceptions;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Nbz4live\JsonRpc\Server\JsonRpcRequest;
use Nbz4live\JsonRpc\Server\Exceptions\Transformers\HttpExceptionTransformer;

class JsonRpcHandler
{
    protected const EXCEPTION_MESSAGE = 'JsonRpc (method:"%s", id:"%s", service:"%s"): #%d %s';

    public function handle(\Exception $exception)
    {
        $error = new \StdClass();

        $handler = app(ExceptionHandler::class);
        $handler->report($exception);

        $exception = $this->transform($exception);

        if ($exception instanceof JsonRpcException) {
            $error->code = $exception->getCode();
            $error->message = $exception->getMessage();
            if (null !== $exception->getData()) {
                $error->data['errors'] = $exception->getData();
            }
        } else {
            $error->code = $exception->getCode();
            $error->message = $exception->getMessage();
        }

        /** @var JsonRpcRequest $request */
        $request = app(JsonRpcRequest::class);

        if (isset($request->call->method)) {
            $logContext = [
                'method' => $request->call->method,
                'call' => class_basename($request->controller) . '::' . $request->method,
                'id' => $request->id,
                'service' => $request->service,
            ];
        } else {
            $logContext = [];
        }

        Log::channel(config('jsonrpc.log.channel', 'default'))
            ->info('Error #' . $error->code . ': ' . $error->message, $logContext);

        return $error;
    }

    protected function transform(\Exception $exception)
    {
        $exceptionTransformers = \config('jsonrpc.exceptionTransformers', [
            HttpException::class => HttpExceptionTransformer::class,
        ]);

        $transformer = $transformers[\get_class($exception)] ?? null;

        if (!$transformer) {
            foreach ($exceptionTransformers as $exceptionClass => $transformerClass) {
                if ($exception instanceof $exceptionClass) {
                    $transformer = $transformerClass;
                }
            }
        }

        if (\is_callable($transformer.'::transform')) {
            return $transformer::transform($exception) ?? $exception;
        }

        return $exception;
    }
}