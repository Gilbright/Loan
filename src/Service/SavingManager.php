<?php
/**
 * Created by PHPstorm.
 * User: Gildas J. Decadjevi
 * Date: 5/10/21
 * Time: 11:42 AM
 */

namespace App\Service;


use App\Entity\Client;
use App\Entity\SavingDetail;
use App\Repository\ClientRepository;
use App\Repository\SavingDetailRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Config\Definition\Exception\Exception;

class SavingManager
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /** @var SavingDetailRepository $savingRepository */
    private $savingRepository;

    /** @var ClientRepository $clientRepository */
    private $clientRepository;

    public function __construct(EntityManagerInterface $entityManager, ClientRepository $clientRepository, SavingDetailRepository $savingDetailRepository)
    {
        $this->clientRepository = $clientRepository;
        $this->savingRepository = $savingDetailRepository;
        $this->entityManager = $entityManager;
    }

    public function getSavingDetails(): array
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
            ->setParameter('end', $endDate)
            ->getQuery()
            ->getResult();
    }

    public function addSaving(array $savingArray, ClientManager $clientManager)
    {
        $currentClient = $clientManager->getClientByIdNumber($savingArray['IdNumber']);

        if (!$currentClient instanceof Client) {
            throw new EntityNotFoundException("Ce identifiant ne correspond a aucun client, veuillez le corriger");
            //TODO: Exception management
        }

        $savingDetail = new SavingDetail();

        $savingDetail->setAmount($savingArray['amount'])
            ->setClientId($currentClient)
            ->setDetailDocumentLink($savingArray['proofDocument'])
            ->setPaidMonth($savingArray['month'])
            ->setType($savingArray['type'])
            ->setExtra($savingArray['details']);

        $this->entityManager->persist($savingDetail);

        //updating the current client's balance
        if ('cotisation' === $savingArray['type']) {
            $currentClient->setBalance($currentClient->getBalance() + $savingArray['amount']);
        } elseif ('defalcation' === $savingArray['type']) {
            $currentClient->setBalance($currentClient->getBalance() - $savingArray['amount']);
        } else {
            throw new Exception("Vous devez choisir soit la cotisation ou defalcation comme type");

            //TODO : Manage exception throwing
        }

        $this->entityManager->flush();
    }

}