<?php
/**
 * Created by PHPstorm.
 * User: Marwane Tchassama
 * Date: 5.03.2021
 * Time: 23:13
 */

namespace App\Service\OptionsResolver;


use Symfony\Component\OptionsResolver\OptionsResolver as SymfonyOptionsResolver;

class SavingDetailResolver extends AbstractOptionResolver
{
    /**
     * @param $data
     * @return mixed
     */
    public static function _resolve($data)
    {
        $data = (new SymfonyOptionsResolver())
            ->setRequired([
                'type',
                'amount'
            ])
            ->setAllowedTypes('type', 'string')
            ->setAllowedTypes('amount', ['float', 'int', 'string'])
            ->resolve($data)
        ;
        return $data;
    }
}