<?php

declare(strict_types=1);
/**
 * 本文件属于KK馆版权所有，泄漏必究。
 * This file belong to KKGUAN, all rights reserved.
 */
namespace KkErpService\RpcUtils\Packer;

use KkErpService\RpcUtils\Exception\RpcException;

class DataFormatter
{
    public static function formatRequest($data)
    {
        [$path, $params, $id] = $data;
        return [
            'jsonrpc' => '2.0',
            'method' => $path,
            'params' => $params,
            'id' => $id,
            'context' => [],
        ];
    }

    public static function formatResponse($data)
    {
        var_dump($data);
        if (array_key_exists('result', $data)) {
            if ($data['result'] === null) {
                return null;
            }
            return $data['result'];
        }

        if ($code = $data['error']['code'] ?? null) {
            $error = $data['error'];
            throw new RpcException($error['message'] ?? '', $code);
        }

        throw new RpcException('Invalid response.');
    }

    public static function formatErrorResponse($data)
    {
        [$id, $code, $message, $data] = $data;

        if (isset($data) && $data instanceof \Throwable) {
            $data = [
                'class' => get_class($data),
                'code' => $data->getCode(),
                'message' => $data->getMessage(),
            ];
        }
        return [
            'jsonrpc' => '2.0',
            'id' => $id ?? null,
            'error' => [
                'code' => $code,
                'message' => $message,
                'data' => $data,
            ],
            'context' => [],
        ];
    }
}
