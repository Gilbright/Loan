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
use App\Helper\Status;
use App\Helper\TypeHelper;
use App\Helper\UploaderHelper;
use App\Repository\PaymentDetailsRepository;
use App\Service\OptionsResolver\PaymentDetailResolver;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\Pure;

class PaymentManager
{
    private EntityManagerInterface $entityManager;

    private ProjectManager $projectManager;

    private UploaderHelper $uploaderHelper;

    private PaymentDetailsRepository $paymentDetailsRepository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param ProjectManager $projectManager
     * @param PaymentDetailsRepository $paymentDetailsRepository
     */
    public function __construct(EntityManagerInterface $entityManager, ProjectManager $projectManager, PaymentDetailsRepository $paymentDetailsRepository, UploaderHelper $uploaderHelper)
    {
        $this->entityManager = $entityManager;
        $this->projectManager = $projectManager;
        $this->paymentDetailsRepository = $paymentDetailsRepository;
        $this->uploaderHelper = $uploaderHelper;
    }

    public function excecute(array $data)
    {
        $data = PaymentDetailResolver::resolve($data);

        $projectMaster = $this->projectManager->getProjectMasterById($data['requestId']); // send requestId

        $type = $data['dropdownName'] === 'Entree';

        $proofDocument = $this->uploaderHelper->uploadPhenixFile($data['financeDetailDoc'], $projectMaster->getRequestId().'-'.uniqid('', true).UploaderHelper::SAVING_DOC_NAME);

        $paymentDetails = (new PaymentDetails())
            ->setType($type)
            ->setAmount((int)$data['amount'])
            ->setPaymentDetailDoc($proofDocument)
            ->setAmountToReceive($this->calculateAmountToReceive($projectMaster, (int)$data['amount'], strtolower($data['dropdownName'])))
            ->setAmountToSend($this->calculateAmountToSend($projectMaster, (int)$data['amount'], strtolower($data['dropdownName'])))
            ->setProjectMaster($projectMaster)
            ->setDetails($data['paymentDetails']);

        $this->entityManager->persist($paymentDetails);

        if ($data['dropdownName'] === 'Sortie' && !$paymentDetails->getAmountToSend()) {
            return;
        }

        if (!$paymentDetails->getAmountToSend() && !$paymentDetails->getAmountToReceive()) {
            $this->projectManager->changeProjectStatusByProjectMaster($projectMaster, Status::PROJECT_COMPLETED);
        }

        $this->entityManager->flush();
    }

    /**
     * @param ProjectMaster $projectMaster
     * @param int $amount
     * @param string|null $type
     * @return int|null
     */
    #[Pure] public function calculateAmountToReceive(ProjectMaster $projectMaster, int $amount = 0, ?string $type = null): ?int
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

        $result = $projectMaster->getProject()->getFinalAmount() - $amountTotal;

        return $result > 0 ? $result : 0;
    }

    /**
     * @param ProjectMaster $projectMaster
     * @param int $amount
     * @param string|null $type
     * @return int|null
     */
    #[Pure] public function calculateAmountToSend(ProjectMaster $projectMaster, int $amount = 0, ?string $type = null): ?int
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

        $result = $projectMaster->getProject()->getFinalAmount() - $amountTotal;

        return $result > 0 ? $result : 0;
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