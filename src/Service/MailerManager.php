<?php
/**
 * Created by PHPstorm.
 * User: Marwane Tchassama
 * Date: 7.03.2021
 * Time: 14:19
 */

namespace App\Service;


use App\Entity\Client;
use App\Entity\Employee;
use App\Entity\Project;
use App\Entity\ProjectMaster;
use App\Entity\Users;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class MailerManager
{
    const FROM_ADDRESS = 'loanphenix@gmail.com';
    /**
     * @var MailerInterface $mailerSender
     */
    private $mailerSender;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailerSender = $mailer;
    }

    public function sendMailNotification(ProjectMaster $projectMaster, Users $user)
    {
        $mailObject = (new TemplatedEmail())
            ->from(self::FROM_ADDRESS)
            ->to($user->getEmail())
            ->subject('Notification sur le statut du projet ' . $projectMaster->getRequestId())
            ->htmlTemplate('mails/employee_mail.html.twig')
            ->context([
                'project' => $projectMaster->getProject(),
                'user' => $user
            ])
        ;

        //@Todo We will reopen, client mail are not real mail. ça cause des errors...
        $this->deliverMailObject($mailObject);
    }

    public function sendSavingMailNotification(Client $client, Users $user)
    {
        $mailObject = (new TemplatedEmail())
            ->from(self::FROM_ADDRESS)
            ->to($user->getEmail())
            ->subject('Notification sur l épargne ')
            ->htmlTemplate('mails/saving_mail.html.twig')
            ->context([
                'client' => $client,
                'user' => $user
            ])
        ;

        $this->deliverMailObject($mailObject);
    }

    public function deliverMailObject(TemplatedEmail $mailObject)
    {
        $transport = Transport::fromDsn($_ENV['MAILER_DSN']);

        $this->mailerSender->send($mailObject);
    }
}