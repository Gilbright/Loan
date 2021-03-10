<?php
/**
 * Created by PHPstorm.
 * User: Marwane Tchassama
 * Date: 5.03.2021
 * Time: 22:59
 */

namespace App\Helper;


class TypeHelper
{
    public const ENTREE = 'entree';

    public const SORTIE = 'sortie';

    public const TYPE_PARSER = [
        self::SORTIE => false,
        self::ENTREE => true
    ];
}