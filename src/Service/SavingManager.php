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
use App\Helper\MailReceiverHelper;
use App\Helper\UploaderHelper;
use App\Repository\SavingDetailsRepository;
use Doctrine\ORM\EntityManagerInterface;

class SavingManager
{
    private EntityManagerInterface $entityManager;

    private SavingDetailsRepository $savingRepository;

    private ClientManager $clientManager;

    private UploaderHelper $uploaderHelper;

    /**@var EmployeeManager $employeeManager */
    private $employeeManager;

    /**
     * @var MailerManager $mailerManager
     */
    private $mailerManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        SavingDetailsRepository $savingDetailRepository,
        ClientManager $clientManager,
        MailerManager $mailerManager,
        EmployeeManager $employeeManager,
        UploaderHelper $uploaderHelper
    )
    {
        $this->savingRepository = $savingDetailRepository;
        $this->entityManager = $entityManager;
        $this->clientManager = $clientManager;
        $this->mailerManager = $mailerManager;
        $this->employeeManager = $employeeManager;
        $this->uploaderHelper = $uploaderHelper;
    }

    public function getAllSavingDetails(): array
    {
        try {
            return $this->savingRepository->findBy([], ['updatedAt' => 'DESC']);
        } catch (\Throwable $exception) {
            return [];
        }
    }

    public function getSavingInDateRange(\DateTime $startDate, \DateTime $endDate)
    {
        return $this->savingRepository->createQueryBuilder('s')
            ->andWhere('s.updatedAt BETWEEN :start AND :end')
            ->setParameter('start', $startDate)
            ->setParameter('end', $endDate->modify('+1 day'))
            ->getQuery()
            ->getResult();
    }

    public function addSaving(array $savingArray)
    {
        $clientInfos = $this->clientManager->getClientByIdNumber($savingArray['IdNumber']);

        $proofDocument = $this->uploaderHelper->uploadPhenixFile($savingArray['proofDocument'], $clientInfos->getIdDocNumber().'-'.uniqid('', true).UploaderHelper::SAVING_DOC_NAME);

        $savingDetail = (new SavingDetails())
            ->setAmount($savingArray['amount'])
            ->setClient($clientInfos)
            ->setDetailDocUrl($proofDocument)
            ->setPaidMonth($savingArray['month'])
            ->setType('cotisation' === $savingArray['type'] ? 1 : 0)
            ->setDetails($savingArray['details'])
            ->setExtra([]);

        //updating the client's balance
        if ('cotisation' === $savingArray['type']) {
            $clientInfos->setBalance($clientInfos->getBalance() + (int)$savingArray['amount']);
        } elseif ('defalcation' === $savingArray['type']) {
            $clientInfos->setBalance($clientInfos->getBalance() - (int)$savingArray['amount']);
        }

        $this->notifySaving($clientInfos);

        $this->entityManager->persist($savingDetail);
        $this->entityManager->flush();
    }

    public function notifySaving(Client $client)
    {
        $user = $this->employeeManager->getUsersByRole(MailReceiverHelper::getSavingMailReceiver())[0];

        $this->mailerManager->sendSavingMailNotification($client, $user);

    }
}