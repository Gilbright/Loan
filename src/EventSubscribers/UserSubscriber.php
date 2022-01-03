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
use App\Entity\PaymentDetails;
use App\Entity\SavingDetails;
use App\Entity\Users;
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

        /** @var Users $currentUser */
        $currentUser = $this->security->getUser();

        if (!$currentUser){
            return;
        }

        if ($entity instanceof SavingDetails) {
            $entity->setUser($currentUser);

            return;
        }

        if ($entity instanceof PaymentDetails) {
            $entity->setUser($currentUser);

            return;
        }

        if ($entity instanceof Note) {
            $authorRole = current(array_filter($currentUser->getRoles(), static function ($role) {
                return $role !== 'ROLE_USER';
            }));

            $entity
                ->setUser($currentUser)
                ->setUserRoleTranslate(RoleTranslator::translate($authorRole))
            ;
        }
    }
}