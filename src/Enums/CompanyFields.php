<?php

declare(strict_types=1);

namespace Elegantly\Pappers\Enums;

enum CompanyFields: string
{
    case Officers = 'officers';
    case Ubos = 'ubos';
    case Financials = 'financials';
    case Documents = 'documents';
    case Certificates = 'certificates';
    case Publications = 'publications';
    case Establishments = 'establishments';
    case Contacts = 'contacts';
}
