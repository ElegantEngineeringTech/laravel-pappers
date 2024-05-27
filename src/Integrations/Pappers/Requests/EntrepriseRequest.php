<?php

namespace Elegantly\Pappers\Integrations\Pappers\Requests;

use Elegantly\Pappers\Enums\FormatPublicationsBodacc;
use Illuminate\Support\Arr;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class EntrepriseRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly ?string $siren = null,
        protected readonly ?string $siret = null,
        protected readonly ?bool $integrer_diffusions_partielles = null,
        protected readonly ?FormatPublicationsBodacc $format_publications_bodacc = null,
        protected readonly ?bool $marques = null,
        protected readonly ?bool $validite_tva_intracommunautaire = null,
        protected readonly ?bool $publications_bodacc_brutes = null,
        protected readonly array|string|null $champs_supplementaires = null,
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
            'champs_supplementaires' => Arr::join(Arr::wrap($this->champs_supplementaires), ','),
        ], fn ($value) => $value !== null);
    }

    public function resolveEndpoint(): string
    {
        return '/entreprise/';
    }
}
