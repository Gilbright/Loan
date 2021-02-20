<?php


namespace App\Service\OptionsResolver;


use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientResolver extends AbstractOptionResolver
{
    public static function _resolve(array $data)
    {
        $data = (new OptionsResolver())
            ->setRequired([
                'nameSurname',
                'birthDate',
                'gender',
                'nationality',
                'phoneNumber',
                'email',
                'profession',
                'monthlyIncome',
                'address',
                'idNumber',
                'confirm'
                ])
            ->setAllowedTypes('nameSurname', 'string')
            ->setAllowedTypes('birthDate', ['string', 'DateTime'])
            ->setAllowedTypes('gender', ['string', 'int', 'bool'])
            ->setAllowedTypes('nationality', 'string')
            ->setAllowedTypes('phoneNumber',['string', 'int'] )
            ->setAllowedTypes('email', 'string')
            ->setAllowedTypes('profession', 'string')
            ->setAllowedTypes('monthlyIncome', ['string', 'int'])
            ->setAllowedTypes('address', 'string')
            ->setAllowedTypes('idNumber', ['string', 'int'])
            ->setAllowedTypes('confirm', ['string', 'int'])
            ->resolve($data)
        ;
    }
}