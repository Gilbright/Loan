<?php


namespace App\Service\OptionsResolver;

abstract class AbstractOptionResolver
{
    public static function resolve($data): array
    {
        return self::_resolve($data);
    }

    public static function _resolve($data)
    {
        return $data;
    }
}