<?php


namespace App\Service\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolver as SymfonyOptionsResolver;


class ProjectResolver extends AbstractOptionResolver
{
    /**
     * @param $data
     * @return mixed
     */
    public static function _resolve($data)
    {
        $data = (new SymfonyOptionsResolver())
            ->setRequired([
                'projectName',
                'projectDetails',
                'amountWanted',
                'modalityAmount',
                'modalityNumberOfMonths',
                'businessPlanDoc',
                'confirmation'
            ])
            ->setAllowedTypes('projectName', 'string')
            ->setAllowedTypes('projectDetails', 'string')
            ->setAllowedTypes('amountWanted', ['float', 'int', 'string'])
            ->setAllowedTypes('modalityAmount',  ['float', 'int', 'string'])
            ->setAllowedTypes('businessPlanDoc',  'string')
            ->setAllowedTypes('modalityNumberOfMonths', ['int', 'string'])
            ->setAllowedTypes('confirmation' , 'string')
            ->resolve($data)
        ;
        return $data;
    }
}