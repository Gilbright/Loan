<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AmountDisplay extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('getDisplay', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    public function doSomething($amount): string
    {
        return round($amount, 2) === 0.00 ? '--' : $amount;
    }
}
