<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class SavingType extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('getSavingType', [$this, 'doSomething']),
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
        return $value ? 'cotisation' : 'defalcation';
    }
}
