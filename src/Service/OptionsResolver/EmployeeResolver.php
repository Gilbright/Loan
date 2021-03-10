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
                'idDocNumber',
                'role',
                'address',
                'gender'
                ])
            ->setAllowedTypes('nameSurname', 'string')
            ->setAllowedTypes('birthDate', ['string', 'DateTime'])
            ->setAllowedTypes('nationality', 'string')
            ->setAllowedTypes('phoneNumber',['string', 'int'] )
            ->setAllowedTypes('email', 'string')
            ->setAllowedTypes('idDocNumber', 'string')
            ->setAllowedTypes('role', 'string')
            ->setAllowedTypes('address', 'string')
            ->setAllowedTypes('gender', 'string')
            ->resolve($data)
        ;
        return $data;
    }
}