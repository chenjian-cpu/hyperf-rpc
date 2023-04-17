<?php

declare(strict_types=1);
/**
 * 本文件属于KK馆版权所有，泄漏必究。
 * This file belong to KKGUAN, all rights reserved.
 */
class RpcTest extends \PHPUnit\Framework\TestCase
{
    public function testRpc()
    {
        $rpcConfig = new \KkErpService\RpcUtils\Structures\RpcConfig();
        $rpcConfig->baseUri = '127.0.0.1:1001';
        $clientFactory = new \KkErpService\RpcUtils\ClientFactory($rpcConfig);

        $serverName = new \KkErpService\RpcUtils\Structures\RpcServerName();
        $serverName->setServiceName('ExportService');
        $serverName->setMethod('createExport');

        $create = new \KkErpService\RpcUtils\Structures\Request\ExportService\CreateExportDTO();
        $create->exportName = '测试sss';
        $create->exportHeader = ['阿发', '十多个'];
        $create->appId = '啥大概是s';
        $create->userId = 'sggh';
        $res = $clientFactory->request($serverName, $create);
        var_dump($res);
        $this->assertIsString($res);
    }
}
