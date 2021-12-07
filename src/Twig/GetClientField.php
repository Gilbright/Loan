<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class GetClientField extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('getField', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    public function doSomething(array $clientKey): string
    {
        [$key, $client] = array_values($clientKey);

        return match ($key) {
            'fullName'      => $client->getFullName(),
            'phoneNumber'   => $client->getPhoneNumber(),
            'email'         => $client->getEmail(),
            'nationality'   => $client->getNationality(),
            'address'       => $client->getAddress(),
            'monthlyIncome' => $client->getMonthlyIncome(),
            'birthDate'     => $client->getBirthDate()->format('Y-m-d'),
            'profession'    => $client->getProfession(),
            default         => '',
        };
    }
}
