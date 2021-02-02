<?php


namespace App\Helper;


class Status
{
    public const WAITING_FOR_CONTROL = 'EN ATTENTE DE CONTROLE';

    public const WAITING_FOR_ANALYSIS = 'EN ATTENTE D ETUDE';

    public const ANALYSIS_ON_GOING = 'EN COURS D ETUDE';

    public const INTERVIEW_STEP = 'ETAPE D ENTRETIEN';

    public const POST_INTERVIEW_STEP = 'POST ENTRETIEN';

    public const MANAGER_ANALYSIS = 'ANALYSE DU MANAGER';

    public const BEEN_VALIDATED = 'VALIDE';

    public const REJECTED = 'REJETE';

    public const LACKING_FUND = 'PROJET MANQUANT DE FONDS';

    public const VALIDATED_FINANCED = 'VALIDE FINANCE';

    public const TO_BE_REANALYZED = 'PROJET A REVOIR';
}