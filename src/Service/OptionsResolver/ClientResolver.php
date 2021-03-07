<?php


namespace App\Service\OptionsResolver;


use Symfony\Component\OptionsResolver\OptionsResolver as SymfonyOptionsResolver;

class ClientResolver extends AbstractOptionResolver
{
    /**
     * @param $data
     * @return mixed
     */
    public static function _resolve($data)
    {
        $data = (new SymfonyOptionsResolver())
            ->setRequired([
                'nameSurname',
                'birthDate',
                'nationality',
                'phoneNumber',
                'email',
                'profession',
                'monthlyIncome',
                'address',
                'idNumber',
                'confirm',
                'idNumber',
                'gender'
                ])
            ->setAllowedTypes('nameSurname', 'string')
            ->setAllowedTypes('birthDate', ['string', 'DateTime'])
            ->setAllowedTypes('nationality', 'string')
            ->setAllowedTypes('phoneNumber',['string', 'int'] )
            ->setAllowedTypes('email', 'string')
            ->setAllowedTypes('profession', 'string')
            ->setAllowedTypes('monthlyIncome', ['string', 'int'])
            ->setAllowedTypes('address', 'string')
            ->setAllowedTypes('idNumber', ['string', 'int'])
            ->setAllowedTypes('confirm', ['string', 'int'])
            ->setAllowedTypes('idNumber', 'string')
            ->setAllowedTypes('gender', 'string')
            ->resolve($data)
        ;
        return $data;
    }
}