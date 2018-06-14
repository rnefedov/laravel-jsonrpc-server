<?php

namespace Nbz4live\JsonRpc\Server\Exceptions\RPC;

use Illuminate\Support\MessageBag;
use Nbz4live\JsonRpc\Server\Exceptions\JsonRpcException;

/**
 * Class WebServiceException
 * @package App\Exceptions
 */
class InvalidParametersException extends JsonRpcException
{
    /**
     * InvalidParametersException constructor.
     *
     * @param MessageBag      $messageBag
     * @param \Exception|null $previous
     */
    public function __construct(MessageBag $messageBag, \Exception $previous = null)
    {
        $error = [];

        foreach ($messageBag->toArray() as $code => $message) {
            $error[] = [
                'code'    => $code,
                'message' => reset($message),
            ];
        }

        parent::__construct(self::CODE_INVALID_PARAMETERS, null, $error, $previous);
    }
}