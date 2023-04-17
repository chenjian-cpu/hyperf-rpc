<?php

declare(strict_types=1);
/**
 * 本文件属于KK馆版权所有，泄漏必究。
 * This file belong to KKGUAN, all rights reserved.
 */
namespace KkErpService\RpcUtils\Structures;

use KkErpService\RpcUtils\Kernel\Str;

class RpcServerName
{
    protected $serviceName;

    protected $method;

    /**
     * @param mixed $serviceName
     */
    public function setServiceName($serviceName): self
    {
        $this->serviceName = $serviceName;
        return $this;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method): self
    {
        $this->method = $method;
        return $this;
    }

    public function getPath()
    {
        $handledNamespace = explode('\\', $this->serviceName);
        $handledNamespace = Str::replaceArray('\\', ['/'], end($handledNamespace));
        $handledNamespace = Str::replaceLast('Service', '', $handledNamespace);
        $path = string_to_hump($handledNamespace);

        if ($path[0] !== '/') {
            $path = '/' . $path;
        }
        return $path . '/' . $this->method;
    }
}
