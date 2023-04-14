<?php

declare(strict_types=1);
/**
 * 本文件属于KK馆版权所有，泄漏必究。
 * This file belong to KKGUAN, all rights reserved.
 */
namespace KkErpService\RpcUtils;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use KkErpService\RpcUtils\Exception\RpcException;
use KkErpService\RpcUtils\Packer\DataFormatter;
use KkErpService\RpcUtils\Packer\PackerInterface;
use KkErpService\RpcUtils\Packer\PhpSerializerPacker;
use KkErpService\RpcUtils\Structures\AbstractDTO;
use KkErpService\RpcUtils\Structures\RpcConfig;

class ClientFactory
{
    protected $rpcConfig = [];

    /**
     * @var Client
     */
    protected $client;

    protected $path;

    /**
     * @var PackerInterface
     */
    protected $packer = PhpSerializerPacker::class;

    public function __construct(RpcConfig $rpcConfig)
    {
        $this->rpcConfig = $rpcConfig;
        $this->client = new Client([
            'base_uri' => $rpcConfig->host,
        ]);
    }

    public function setPacker(string $packer): self
    {
        $this->packer = $packer;
        return $this;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path): self
    {
        $this->path = $path;
        return $this;
    }

    public function request(AbstractDTO $dto)
    {
        try {
            $startTime = microtime(true);
            $id = uniqid('rpc_', true);
            $packer = new $this->packer();
            $body = $packer->pack(DataFormatter::formatRequest([$this->path, [$dto], $id]));
            $response = $this->client->post('', [
                RequestOptions::HEADERS => [
                    'Content-Type' => 'application/rpc',
                ],
                RequestOptions::HTTP_ERRORS => false,
                RequestOptions::BODY => $body,
            ]);
            if ($response->getStatusCode() != 200) {
                throw new RpcException('Invalid response.');
            }
            return $content = DataFormatter::formatResponse($packer->unpack($response->getBody()->getContents()));
        } catch (\Throwable $e) {
            $throwable = $e;
            throw $e;
        } finally {
            if (isset($throwable)) {
                $content = [
                    'code' => $throwable->getCode(),
                    'message' => '[rpc_request_error]' . $throwable->getMessage(),
                    'file' => $throwable->getFile(),
                    'line' => $throwable->getLine(),
                ];
            }
            $this->log($id, $this->path, $body, $content, $startTime);
        }
    }

    protected function log(string $id, string $method, $args, $content, float $startTime): bool
    {
        if (! is_string($args)) {
            $args = json_encode($args, JSON_UNESCAPED_UNICODE);
        }
        if (! is_string($content)) {
            $content = json_encode($content, JSON_UNESCAPED_UNICODE);
        }

        $message = sprintf('[%s] [RPC请求日志] [本次耗时]%s [RPC方法]%s [请求参数]%s [响应结果]%s', $id, get_elapsed_time($startTime), $method, $args, $content);

        echo $message;

        return true;
    }
}
