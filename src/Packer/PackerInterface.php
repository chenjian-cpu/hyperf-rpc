<?php

declare(strict_types=1);
/**
 * 本文件属于KK馆版权所有，泄漏必究。
 * This file belong to KKGUAN, all rights reserved.
 */
namespace KkErpService\RpcUtils\Packer;

interface PackerInterface
{
    public function pack($data): string;

    public function unpack(string $data);
}
