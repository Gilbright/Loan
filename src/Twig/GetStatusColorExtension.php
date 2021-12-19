<?php

namespace App\Twig;

use App\Helper\TypeColorHelper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class GetStatusColorExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('get_badge', [$this, 'doSomething']),
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
        return TypeColorHelper::findBadgeColor($value);
    }
}
