<?php
/**
 * Created by PHPstorm.
 * User: Marwane Tchassama
 * Date: 5.03.2021
 * Time: 23:13
 */

namespace App\Service\OptionsResolver;


use Symfony\Component\OptionsResolver\OptionsResolver as SymfonyOptionsResolver;

class FinancialDetailResolver extends AbstractOptionResolver
{
    /**
     * @param $data
     * @return mixed
     */
    public static function _resolve($data)
    {
        $data = (new SymfonyOptionsResolver())
            ->setRequired([
                'dropdownName',
                'amount',
                'paymentDetails'
            ])
            ->setAllowedTypes('dropdownName', 'string')
            ->setAllowedTypes('amount', ['float', 'int', 'string'])
            ->setAllowedTypes('paymentDetails' , 'string')
            ->resolve($data)
        ;
        return $data;
    }
}