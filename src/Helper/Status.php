<?php


namespace App\Helper;


class Status
{
    public const SEC_WAITING_FOR_CONTROL = 'EN ATTENTE DE CONTROLE';

    public const EXP_WAITING_FOR_ANALYSIS = 'EN ATTENTE D ETUDE';

    public const EXP_ANALYSIS_ON_GOING = 'EN COURS D ETUDE';

    public const EXP_INTERVIEW_STEP = 'ETAPE D ENTRETIEN';

    public const EXP_POST_INTERVIEW = 'POST ENTRETIEN'; // A revoir --> enlevable

    public const BOS_MANAGER_ANALYSIS = 'ANALYSE DU MANAGER';

    public const BOS_MANAGER_ANALYSIS_GOING_ON = 'ANALYSE DU MANAGER EN COURS'; // newly added

    public const BOS_BEEN_VALIDATED = 'VALIDE';

    public const EXP_REJECTED = 'REJETE';

    public const ACC_LACKING_FUND = 'PROJET MANQUANT DE FONDS';

    public const ACC_VALIDATED_FINANCED = 'VALIDE FINANCE';

    public const BOS_TO_BE_REANALYZED = 'PROJET A REVOIR';
}