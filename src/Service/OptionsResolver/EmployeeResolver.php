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
                'role',
                'address',
                ])
            ->setAllowedTypes('nameSurname', 'string')
            ->setAllowedTypes('birthDate', ['string', 'DateTime'])
            ->setAllowedTypes('nationality', 'string')
            ->setAllowedTypes('phoneNumber',['string', 'int'] )
            ->setAllowedTypes('email', 'string')
            ->setAllowedTypes('role', 'string')
            ->setAllowedTypes('address', 'string')
            ->resolve($data)
        ;
        return $data;
    }
}