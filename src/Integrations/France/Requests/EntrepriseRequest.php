<?php

declare(strict_types=1);

namespace Elegantly\Pappers\Integrations\France\Requests;

use Elegantly\Pappers\Enums\EntrepriseChampsSupplementaires;
use Elegantly\Pappers\Enums\FormatPublicationsBodacc;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class EntrepriseRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  EntrepriseChampsSupplementaires[]  $champs_supplementaires
     */
    public function __construct(
        protected readonly ?string $siren = null,
        protected readonly ?string $siret = null,
        protected readonly ?bool $integrer_diffusions_partielles = true,
        protected readonly ?FormatPublicationsBodacc $format_publications_bodacc = null,
        protected readonly ?bool $marques = null,
        protected readonly ?bool $validite_tva_intracommunautaire = null,
        protected readonly ?bool $publications_bodacc_brutes = null,
        protected readonly array $champs_supplementaires = [],
    ) {
        //
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'siren' => $this->siren,
            'siret' => $this->siret,
            'integrer_diffusions_partielles' => $this->integrer_diffusions_partielles,
            'format_publications_bodacc' => $this->format_publications_bodacc?->value,
            'marques' => $this->marques,
            'validite_tva_intracommunautaire' => $this->validite_tva_intracommunautaire,
            'publications_bodacc_brutes' => $this->publications_bodacc_brutes,
            'champs_supplementaires' => collect($this->champs_supplementaires)
                ->map(fn (EntrepriseChampsSupplementaires $item) => $item->value)
                ->implode(','),
        ], fn ($value) => ! blank($value));
    }

    public function resolveEndpoint(): string
    {
        return '/entreprise/';
    }
}
