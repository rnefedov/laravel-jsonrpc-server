<?php

namespace Nbz4live\JsonRpc\Server\Testing\Concerns;

trait MakesJsonRpcRequests
{
    protected $uri;

    public function jsonRpc(string $method, array $params = null, string $uri = null): self
    {
        $rpcCall = [
            'jsonrpc' => '2.0',
            'method' => $method,
        ];

        if ($params) {
            $rpcCall['params'] = $params;
        }

        return $this->json('POST', $uri ?? $this->uri, $rpcCall);
    }

    /**
     * Assert that the JSON-RPC result has a given structure.
     *
     * @param  array|null  $structure
     * @param  array|null  $responseData
     * @return $this
     */
    public function seeJsonRpcStructure(array $structure = null, $responseData = null)
    {
        return $this->seeJsonStructure(['jsonrpc', 'result' => $structure], $responseData);
    }


    /**
     * Assert that the client response is a valid jsonrpc response.
     */
    public function assertIsJsonRpcResponse()
    {
        $this->seeJsonStructure(['jsonrpc']);
    }


    /**
     * Assert that the client response has no errors.
     *
     * @param bool $negate
     */
    public function assertJsonRpcResponseOk()
    {
        $this->seeJsonStructure(['jsonrpc', 'result']);
    }

    /**
     * Assert that the client response has errors.
     */
    public function seeJsonRpcError(int $code = null)
    {
        $this->seeJsonStructure(['jsonrpc', 'error']);

        if ($code) {
            $this->seeJsonContains(['code' => $code]);
        }

    }

    /**
     * @param string $uri
     */
    public function setUri(string $uri): void
    {
        $this->uri = $uri;
    }
}
