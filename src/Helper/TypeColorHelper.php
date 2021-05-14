<?php
/**
 * Created by PHPstorm.
 * User: Marwane Tchassama
 * Date: 8.03.2021
 * Time: 23:45
 */

namespace App\Helper;


class TypeColorHelper
{
    public const CARDS = [
        Status::SEC_WAITING_FOR_CONTROL => 'card-navy',
        Status::EXP_WAITING_FOR_ANALYSIS => 'card-primary',
        Status::EXP_ANALYSIS_ON_GOING => 'card-warning',
        Status::EXP_REJECTED => 'card-danger',
        Status::EXP_INTERVIEW_STEP => 'card-info',
        Status::EXP_POST_INTERVIEW => 'card-lightblue',
        Status::BOS_MANAGER_ANALYSIS => 'card-lime',
        Status::BOS_MANAGER_ANALYSIS_GOING_ON => 'card-olive',
        Status::BOS_BEEN_VALIDATED => 'card-success',
        Status::ACC_VALIDATED_FINANCED => 'card-teal',
        Status::ACC_LACKING_FUND => 'card-fuchsia',
        Status::BOS_TO_BE_REANALYZED => 'card-orange',
        Status::PROJECT_COMPLETED => 'card-gray'
    ];
    public const BADGES = [
        Status::SEC_WAITING_FOR_CONTROL => 'badge badge-pill bg-navy',
        Status::EXP_WAITING_FOR_ANALYSIS => 'badge badge-pill bg-primary',
        Status::EXP_ANALYSIS_ON_GOING => 'badge badge-pill bg-warning',
        Status::EXP_REJECTED => 'badge badge-pill bg-danger',
        Status::EXP_INTERVIEW_STEP => 'badge badge-pill bg-info',
        Status::EXP_POST_INTERVIEW => 'badge badge-pill bg-lightblue',
        Status::BOS_MANAGER_ANALYSIS => 'badge badge-pill bg-lime',
        Status::BOS_MANAGER_ANALYSIS_GOING_ON => 'badge badge-pill bg-olive',
        Status::BOS_BEEN_VALIDATED => 'badge badge-pill bg-success',
        Status::ACC_VALIDATED_FINANCED => 'badge badge-pill bg-teal',
        Status::ACC_LACKING_FUND => 'badge badge-pill bg-fuchsia',
        Status::BOS_TO_BE_REANALYZED => 'badge badge-pill bg-orange',
        Status::PROJECT_COMPLETED => 'badge badge-pill bg-secondary'
    ];

    public static function findCardColor($status){
        return self::CARDS[$status];
    }

    public static function findBadgeColor($status){
        return self::BADGES[$status];
    }
}

