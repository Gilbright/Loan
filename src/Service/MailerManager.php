<?php
/**
 * Created by PHPstorm.
 * User: Marwane Tchassama
 * Date: 7.03.2021
 * Time: 14:19
 */

namespace App\Service;


use App\Entity\Employee;
use App\Entity\Project;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerManager
{
    /**
     * @var MailerInterface $mailerSender
     */
    private $mailerSender;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailerSender = $mailer;
    }

    public function sendMailNotification(Project $project,Employee $employee)
    {
        $mailObject = (new TemplatedEmail())
            ->from('loanphenix@gmail.com')
            ->to($employee->getEmail())
            ->subject('Notification sur le statut du projet ' . $project->getProjectId())
            ->htmlTemplate('mails/employee_mail.html.twig')
            ->context([
                'project' => $project,
                'employee' => $employee
            ])
        ;

        //@Todo We will reopen, client mail are not real mail. ça cause des errors...
        //$this->mailerSender->send($mailObject);
    }
}