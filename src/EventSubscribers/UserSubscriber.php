<?php
/**
 * Created by PHPstorm.
 * User: Marwane Tchassama
 * Date: 18.07.2021
 * Time: 22:25
 */

namespace App\EventSubscribers;


use App\Entity\FinanceDetail;
use App\Entity\Note;
use App\Helper\RoleTranslator;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Security;


class UserSubscriber implements EventSubscriber
{
    /** @var Security */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @return string[]
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->logActivity('persist', $args);
    }

    private function logActivity(string $action, LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof FinanceDetail) {
            $entity->setOperationExecutor($this->security->getUser());
            return;
        }

        if ($entity instanceof Note) {
            $employee = $this->security->getUser();

            $authorRole = current(array_filter($employee->getRoles(), static function ($role) {
                return $role !== 'ROLE_USER';
            }));

            $entity
                ->setEmployee($employee)
                ->setAuthorRole(RoleTranslator::translate($authorRole))
            ;
        }
    }
}