<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class GetRoleExtension extends AbstractExtension
{
    public const  ROLE = [
        'ROLE_SECRETARY'  => 'Secretaire',
        'ROLE_ACCOUNTANT' => 'Tresorier',
        'ROLE_BOSS'       => 'Directeur',
        'ROLE_EXPERT'     => 'Expert'
    ];

    public function getFilters(): array
    {
        return [
            new TwigFilter('getRole', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    public function doSomething($value): string
    {
        return self::ROLE[$value];
    }
}
