<?php

declare(strict_types=1);

namespace Elegantly\Pappers\Enums;

enum EntrepriseChampsSupplementaires: string
{
    // 1 jeton supplémentaire
    case SitesInternet = 'sites_internet';
    case Telephone = 'telephone';
    case Email = 'email';

    // Gratuit
    case Enseigne1 = 'enseigne_1';
    case Enseigne2 = 'enseigne_2';
    case Enseigne3 = 'enseigne_3';
    case DistributionSpeciale = 'distribution_speciale';
    case CodeCedex = 'code_cedex';
    case LibelleCedex = 'libelle_cedex';
    case CodeCommune = 'code_commune';
    case CodeRegion = 'code_region';
    case Region = 'region';
    case CodeDepartement = 'code_departement';
    case Departement = 'departement';
    case NomenclatureCodeNaf = 'nomenclature_code_naf';
    case Labels = 'labels';
    case MicroEntreprise = 'micro_entreprise';

    // 0.5 jeton supplémentaire
    case LabelsOrias = 'labels:orias';
    case LabelsCci = 'labels:cci';
    case Deces = 'deces';

    // 1 jeton supplémentaire
    case Sanctions = 'sanctions';
    case PersonnePolitiquementExposee = 'personne_politiquement_exposee';

    // 30 jetons supplémentaires
    case ScoringFinancier = 'scoring_financier';
    case ScoringNonFinancier = 'scoring_non_financier';

    // Gratuit
    case CategorieEntreprise = 'categorie_entreprise';
}
