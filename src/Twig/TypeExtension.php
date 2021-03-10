<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TypeExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('getType', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    public function doSomething($value)
    {
        return $value ? 'Entree' : 'Sortie';
    }
}
