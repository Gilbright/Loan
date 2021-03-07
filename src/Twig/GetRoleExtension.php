<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class GetRoleExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('getRole', [$this, 'doSomething']),
        ];
    }

    public const  ROLE = [
        'ROLE_SECRETARY' => 'Secretaire',
        'ROLE_ACCOUNTANT' => 'Tresorier',
        'ROLE_BOSS' => 'Directeur',
        'ROLE_EXPERT' => 'Expert'
        ];

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    public function doSomething($value)
    {
        return self::ROLE[$value];
    }
}
