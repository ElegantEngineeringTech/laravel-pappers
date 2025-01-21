<?php

declare(strict_types=1);

namespace Elegantly\Pappers\Integrations\International\Requests;

use Elegantly\Pappers\Enums\CompanyFields;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class CompanyRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  CompanyFields[]  $fields
     */
    public function __construct(
        protected readonly string $country_code,
        protected readonly string $company_number,
        protected readonly array $fields = [],
    ) {
        //
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'country_code' => $this->country_code,
            'company_number' => $this->company_number,
            'fields' => collect($this->fields)
                ->map(fn (CompanyFields $field) => $field->value)
                ->implode(','),
        ], fn ($value) => ! blank($value));
    }

    public function resolveEndpoint(): string
    {
        return '/company/';
    }
}
