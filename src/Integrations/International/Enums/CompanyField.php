<?php

declare(strict_types=1);

namespace Elegantly\Pappers\Integrations\International\Enums;

enum CompanyField: string
{
    case Officers = 'officers';
    case Ubos = 'ubos';
    case Shareholders = 'shareholders';
    case Financials = 'financials';
    case Documents = 'documents';
    case Certificates = 'certificates';
    case Publications = 'publications';
    case Establishments = 'establishments';
    case Contacts = 'contacts';
    case VatNumberValidityCheck = 'vat_number_validity_check';
}
