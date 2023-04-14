<?php

declare(strict_types=1);
/**
 * 本文件属于KK馆版权所有，泄漏必究。
 * This file belong to KKGUAN, all rights reserved.
 */
namespace KkErpService\RpcUtils\Structures;

class QueryDTO extends AbstractDTO
{
    /**
     * @var bool 是否开启分页
     */
    public $forPage = false;

    /**
     * @var int 当前页数
     */
    public $page = 1;

    /**
     * @var int 每页条数
     */
    public $perPage = 10;

    /**
     * @var string[] 查询字段
     */
    public $select = ['*'];

    /**
     * @var int 限制条数，默认不限制，分页开启时，此条件无效
     */
    public $limit = -1;

    /**
     * @var array 忽略的ID
     */
    public $ignoreIds = [];
}
