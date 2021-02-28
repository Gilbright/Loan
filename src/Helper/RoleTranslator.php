<?php
/**
 * Created by PHPstorm.
 * User: Marwane Tchassama
 * Date: 28.02.2021
 * Time: 20:57
 */

namespace App\Helper;


class RoleTranslator
{
    public const ROLE_EN_FR = [
        'ROLE_BOSS' => 'Directeur',
        'ROLE_EXPERT' => 'Expert',
        'ROLE_ACCOUNTANT' => 'Tresorier',
        'ROLE_SECRETARY' => 'Secretaire'
    ];

    /**
     * @param string $role
     * @return string
     */
    public static function translate(string $role): string
    {
        return self::ROLE_EN_FR[$role];
    }
}