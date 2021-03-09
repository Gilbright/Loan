<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class FinancialDetailExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('getAmount', [$this, 'getAmount']),
        ];
    }


    public function getAmount($finalAmount, $amountToBePaidToUs)
    {
        return $amountToBePaidToUs === $finalAmount ? 'Remboursement non amorçé' : $amountToBePaidToUs;
    }
}
