<?php
/**
 * Created by PHPStorm.
 * User: Marwane Tchassama
 * Date: 5.12.2021
 * Time: 18:28
 */

namespace App\Service;

use App\Entity\PaymentDetails;
use App\Entity\ProjectMaster;
use App\Helper\TypeHelper;
use App\Repository\PaymentDetailsRepository;
use App\Service\OptionsResolver\PaymentDetailResolver;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\Pure;

class PaymentManager
{
    private EntityManagerInterface $entityManager;

    private ProjectManager $projectManager;

    private PaymentDetailsRepository $paymentDetailsRepository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param ProjectManager $projectManager
     * @param PaymentDetailsRepository $paymentDetailsRepository
     */
    public function __construct(EntityManagerInterface $entityManager, ProjectManager $projectManager, PaymentDetailsRepository $paymentDetailsRepository)
    {
        $this->entityManager = $entityManager;
        $this->projectManager = $projectManager;
        $this->paymentDetailsRepository = $paymentDetailsRepository;
    }

    public function excecute(array $data)
    {
        $data = PaymentDetailResolver::resolve($data);

        $projectMaster = $this->projectManager->getProjectMasterById($data['requestId']); // send requestId

        $type = $data['dropdownName'] === 'Entree';

        $paymentDetails = (new PaymentDetails())
            ->setType($type)
            ->setAmount((float)$data['amount'])
            ->setPaymentDetailDoc($data['financeDetailDoc'])
            ->setAmountToReceive($this->calculateAmountToReceive($projectMaster, (float)$data['amount'], strtolower($data['dropdownName'])))
            ->setAmountToSend($this->calculateAmountToSend($projectMaster, (float)$data['amount'], strtolower($data['dropdownName'])))
            ->setDetails($data['paymentDetails']);

        $this->entityManager->persist($paymentDetails);
        $this->entityManager->flush();
    }

    /**
     * @param ProjectMaster $projectMaster
     * @param float $amount
     * @param string|null $type
     * @return float|null
     */
    #[Pure] public function calculateAmountToReceive(ProjectMaster $projectMaster, float $amount = 0.0, ?string $type = null): ?float
    {
        $allPaymentDetails = $projectMaster->getPaymentDetails();

        $amountTotal = 0;
        if ($type === TypeHelper::ENTREE) {
            $amountTotal = $amount;
        }

        if ($allPaymentDetails) {
            foreach ($allPaymentDetails as $paymentDetail) {
                if ($paymentDetail->getType()) { // entre => true
                    $amountTotal += $paymentDetail->getAmount();
                }
            }
        }

        return round($projectMaster->getProject()->getFinalAmount() - $amountTotal, 2);
    }

    /**
     * @param ProjectMaster $projectMaster
     * @param float $amount
     * @param string|null $type
     * @return float|null
     */
    #[Pure] public function calculateAmountToSend(ProjectMaster $projectMaster, float $amount = 0.0, ?string $type = null): ?float
    {
        $allPaymentDetails = $projectMaster->getPaymentDetails();

        $amountTotal = 0;
        if ($type === TypeHelper::SORTIE) {
            $amountTotal = $amount;
        }

        if ($allPaymentDetails) {
            foreach ($allPaymentDetails as $paymentDetail) {
                if (!$paymentDetail->getType()) { // sortie => false
                    $amountTotal += $paymentDetail->getAmount();
                }
            }
        }

        return round($projectMaster->getProject()->getFinalAmount() - $amountTotal, 2);
    }

    public function getPaymentDetailsInDateRange(\DateTime $startDate, \DateTime $endDate)
    {
        return $this->paymentDetailsRepository->createQueryBuilder('f')
            ->andWhere('f.updatedAt BETWEEN :start AND :end')
            ->setParameter('start', $startDate)
            ->setParameter('end', $endDate->modify('+1 day'))
            ->getQuery()
            ->getResult();
    }

    public function getAllPaymentDetailsDetails(): array
    {
        try {
            return $this->paymentDetailsRepository->findBy([], ['updatedAt' => 'DESC']);
        } catch (\Throwable $exception) {
            return [];
        }
    }
}