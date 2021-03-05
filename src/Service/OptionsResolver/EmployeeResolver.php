<?php


namespace App\Service\OptionsResolver;


use Symfony\Component\OptionsResolver\OptionsResolver as SymfonyOptionsResolver;

class EmployeeResolver extends AbstractOptionResolver
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
                'address',
                'idNumber',
                'confirm'
                ])
            ->setAllowedTypes('nameSurname', 'string')
            ->setAllowedTypes('birthDate', ['string', 'DateTime'])
            ->setAllowedTypes('nationality', 'string')
            ->setAllowedTypes('phoneNumber',['string', 'int'] )
            ->setAllowedTypes('email', 'string')
            ->setAllowedTypes('profession', 'string')
            ->setAllowedTypes('address', 'string')
            ->setAllowedTypes('idNumber', ['string', 'int'])
            ->setAllowedTypes('confirm', ['string', 'int', 'boolean'])
            ->resolve($data)
        ;
        return $data;
    }
}