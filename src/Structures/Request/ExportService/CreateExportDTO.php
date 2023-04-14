<?php

declare(strict_types=1);
/**
 * This file is part of the KKGUAN Service.
 *
 * (c) KKGUAN Service <>
 *
 * 本文件属于KK馆版权所有，泄漏必究。
 * This file belong to KKGUAN, all rights reserved.
 */
namespace KkErpService\RpcUtils\Structures\Request\ExportService;

use KkErpService\RpcUtils\Structures\AbstractDTO;

class CreateExportDTO extends AbstractDTO
{
    /**
     * 调用方唯一识别id.
     * @var string
     */
    public $appId;

    /**
     * 基础服务-用户服务 用户id.
     * @var string
     */
    public $userId;

    /**
     * 导出任务名称,服务唯一性.
     *
     * @var string
     */
    public $exportName;

    /**
     * excel表头,一维数组.
     *
     * @example ["ID","姓名","性别"]
     * @var array
     */
    public $exportHeader;
}
