<?php
/**
 * Created by PHPstorm.
 * User: Marwane Tchassama
 * Date: 8.03.2021
 * Time: 00:32
 */

namespace App\Helper;


class MailReceiverHelper
{
    public const RECEIVERS = [
        Status::SEC_WAITING_FOR_CONTROL => [RoleHelper::SECRETARY, RoleHelper::BOSS],
        Status::EXP_WAITING_FOR_ANALYSIS => [RoleHelper::EXPERT, RoleHelper::BOSS],
        Status::EXP_INTERVIEW_STEP => [RoleHelper::SECRETARY, RoleHelper::BOSS],
        Status::BOS_MANAGER_ANALYSIS => [RoleHelper::BOSS],
        Status::BOS_BEEN_VALIDATED => [RoleHelper::SECRETARY, RoleHelper::ACCOUNTANT],
        Status::EXP_REJECTED => [RoleHelper::BOSS],
        Status::ACC_LACKING_FUND => [RoleHelper::BOSS],
        Status::ACC_VALIDATED_FINANCED => [RoleHelper::BOSS],
        Status::BOS_TO_BE_REANALYZED => [RoleHelper::EXPERT],
        Status::PROJECT_COMPLETED => [RoleHelper::BOSS, RoleHelper::ACCOUNTANT]
    ];

    public static function getReceiverRoleByStatus($status)
    {
        return self::RECEIVERS[$status] ?? [];
    }
}

//     status non pris en compte par les notifications de mail.
//     public const EXP_ANALYSIS_ON_GOING = 'EN COURS D ETUDE';
//    public const EXP_POST_INTERVIEW = 'POST ENTRETIEN'; // A revoir --> enlevable
//    public const BOS_MANAGER_ANALYSIS_GOING_ON = 'ANALYSE DU MANAGER EN COURS'; // newly added