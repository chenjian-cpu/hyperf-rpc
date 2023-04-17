<?php

declare(strict_types=1);
/**
 * 本文件属于KK馆版权所有，泄漏必究。
 * This file belong to KKGUAN, all rights reserved.
 */
namespace KkErpService\RpcUtils\Structures;

class RpcConfig
{
    public $baseUri;

    public $headers = [
        'Content-Type' => 'application/rpc',
    ];
}
