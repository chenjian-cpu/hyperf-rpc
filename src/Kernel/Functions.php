<?php

declare(strict_types=1);
/**
 * 本文件属于KK馆版权所有，泄漏必究。
 * This file belong to KKGUAN, all rights reserved.
 */
if (! function_exists('get_elapsed_time')) {
    /**
     * 计算耗时.
     * @param float $start 开始时间
     */
    function get_elapsed_time(float $start): float
    {
        return round((microtime(true) - $start) * 1000, 2);
    }
}

if (! function_exists('string_to_hump')) {
    /**
     * 下划线转成驼峰命名,默认小驼峰.
     * @param string $string 要转换的字符串
     * @param bool $firstUp 是否首字母大写,默认否
     */
    function string_to_hump(string $string, bool $firstUp = false): string
    {
        $humpString = implode(
            '',
            array_map('ucfirst', explode('_', $string))
        );

        return $firstUp ? $humpString : lcfirst($humpString);
    }
}

if (! function_exists('string_to_line')) {
    /**
     * 驼峰命名转下划线
     * @param string $string 要转换的字符串
     */
    function string_to_line(string $string): string
    {
        $replaceString = preg_replace_callback('/([A-Z])/', function ($matches) {
            return '_' . strtolower($matches[0]);
        }, $string);

        return trim(preg_replace('/_{2,}/', '_', $replaceString), '_');
    }
}

if (! function_exists('array_key_to_line')) {
    /**
     * 转换数组key成下划线
     * @param array $array 要转换的数组
     */
    function array_key_to_line(array $array): array
    {
        $convert = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $convert[is_string($key) ? string_to_line($key) : $key] = array_key_to_line($value);
            } else {
                $convert[is_string($key) ? string_to_line($key) : $key] = $value;
            }
        }

        return $convert;
    }
}

if (! function_exists('array_key_to_hump')) {
    /**
     * 转换数组key成驼峰.
     * @param array $array 要转换的数组
     */
    function array_key_to_hump(array $array, bool $firstUp = false, bool $loop = true): array
    {
        $convert = [];
        foreach ($array as $key => $value) {
            if (is_array($value) && $loop) {
                $convert[is_string($key) ? string_to_hump($key, $firstUp) : $key] = array_key_to_hump($value, $firstUp);
            } else {
                $convert[is_string($key) ? string_to_hump($key, $firstUp) : $key] = $value;
            }
        }

        return $convert;
    }
}
