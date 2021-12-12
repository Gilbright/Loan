<?php
/**
 * Created by PHPstorm.
 * User: Gildas J. Decadjevi
 * Date: 5/10/21
 * Time: 11:42 AM
 */

namespace App\Service;

use App\Entity\Client;
use App\Entity\SavingDetails;
use App\Repository\SavingDetailsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class SavingManager
{
    private EntityManagerInterface $entityManager;

    private SavingDetailsRepository $savingRepository;

    private ClientManager $clientManager;

    public function __construct(EntityManagerInterface $entityManager, SavingDetailsRepository $savingDetailRepository, ClientManager $clientManager)
    {
        $this->savingRepository = $savingDetailRepository;
        $this->entityManager = $entityManager;
        $this->clientManager = $clientManager;
    }

    public function getAllSavingDetails(): array
    {
        try {
            return $this->savingRepository->findBy([],['updatedAt' => 'DESC']);
        } catch (\Throwable $exception){
            return [];
        }
    }

    public function getSavingInDateRange(\DateTime $startDate, \DateTime $endDate){
        return $this->savingRepository->createQueryBuilder('s')
            ->andWhere('s.updatedAt BETWEEN :start AND :end')
            ->setParameter('start', $startDate)
            ->setParameter('end', $endDate->modify('+1 day'))
            ->getQuery()
            ->getResult()
        ;
    }

    public function addSaving(array $savingArray)
    {
        $clientInfos = $this->clientManager->getClientByIdNumber($savingArray['IdNumber']);

        if (!$clientInfos instanceof Client) {
            throw new EntityNotFoundException("Ce identifiant ne correspond a aucun client, veuillez le corriger");
            //TODO: Exception management
        }

        $savingDetail = (new SavingDetails())
            ->setAmount($savingArray['amount'])
            ->setClient($clientInfos)
            ->setDetailDocUrl($savingArray['proofDocument'])
            ->setPaidMonth($savingArray['month'])
            ->setType($savingArray['type'])
            ->setDetails($savingArray['details'])
            ->setExtra([]);
        ;

        //updating the client's balance
        if ('cotisation' === $savingArray['type']) {
            $clientInfos->setBalance($clientInfos->getBalance() + (float)$savingArray['amount']);
        } elseif ('defalcation' === $savingArray['type']) {
            $clientInfos->setBalance($clientInfos->getBalance() - (float)$savingArray['amount']);
        }

        $this->entityManager->persist($savingDetail);
        $this->entityManager->flush();
    }
}