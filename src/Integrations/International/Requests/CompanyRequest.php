<?php

declare(strict_types=1);

namespace Elegantly\Pappers\Integrations\International\Requests;

use Elegantly\Pappers\Integrations\International\Enums\CompanyField;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class CompanyRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  array<array-key, string|CompanyField>  $fields
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
            'fields' => implode(',', array_map(
                fn ($field) => $field instanceof CompanyField ? $field->value : $field,
                $this->fields
            )),
        ], fn ($value) => ! blank($value));
    }

    public function resolveEndpoint(): string
    {
        return '/company/';
    }
}
