<?php

namespace App\Twig;

use App\Entity\Client;
use App\Helper\TypeColorHelper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class GetClientField extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('getField', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    public function doSomething(array $clientKey)
    {
        /** Client $client */

        /** @var  Client $client */
        [$key, $client] = array_values($clientKey);

        switch ($key){
            case 'nameSurname':
                return $client->getNameSurname();
            case 'idDocNumber':
                return $client->getIdDocNumber();
            case 'phoneNumber':
                return $client->getPhoneNumber();
            case 'email':
                return $client->getEmail();
            case 'nationality':
                return $client->getNationality();
            case 'gender':
                return $client->getGender();
            case 'address':
                return $client->getAddress();
            case 'monthlyIncome':
                return $client->getMonthlyIncome();
            case 'birthDate':
                return $client->getBirthDate();
            case 'profession':
                return $client->getProfession();
            default:
                return '';
        }
    }
}
