<?php

declare(strict_types=1);

namespace Elegantly\Pappers\Integrations\France;

use Elegantly\Pappers\Integrations\France\Requests\EntrepriseRequest;
use Illuminate\Support\Facades\Cache;
use Saloon\CachePlugin\Contracts\Cacheable;
use Saloon\CachePlugin\Contracts\Driver;
use Saloon\CachePlugin\Drivers\LaravelCacheDriver;
use Saloon\CachePlugin\Traits\HasCaching;
use Saloon\Http\Auth\QueryAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\Response;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;
use Saloon\RateLimitPlugin\Limit;
use Saloon\RateLimitPlugin\Stores\LaravelCacheStore;
use Saloon\RateLimitPlugin\Traits\HasRateLimits;

/**
 * @see documentation at https://www.pappers.fr/api/documentation#tag/Fiche-entreprise/operation/entreprise
 */
class PappersFranceConnector extends Connector implements Cacheable
{
    use HasCaching;
    use HasRateLimits;

    public function __construct(
        public string $token,
        public string $version
    ) {
        $this->cachingEnabled = config()->boolean('pappers.cache.enabled', true);
        $this->useRateLimitPlugin(config()->boolean('pappers.rate_limit.enabled', false));
    }

    protected function defaultAuth(): QueryAuthenticator
    {
        return new QueryAuthenticator('api_token', $this->token);
    }

    public function resolveBaseUrl(): string
    {
        return "https://api.pappers.fr/{$this->version}/";
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    public function resolveCacheDriver(): Driver
    {
        return new LaravelCacheDriver(Cache::store(
            config()->string('pappers.cache.driver', 'file')
        ));
    }

    public function cacheExpiryInSeconds(): int
    {
        return config()->integer('pappers.cache.expiry_seconds', 604_800);
    }

    protected function resolveRateLimitStore(): RateLimitStore
    {
        return new LaravelCacheStore(Cache::store(
            config()->string('pappers.rate_limit.driver', 'array')
        ));
    }

    /**
     * @return Limit[]
     */
    protected function resolveLimits(): array
    {
        return [
            Limit::allow(
                config()->integer('pappers.rate_limit.every_minute', 30)
            )->everyMinute(),
        ];
    }

    public function siren(string $siren): Response
    {
        return $this->send(new EntrepriseRequest(
            siren: $siren
        ));
    }

    public function siret(string $siret): Response
    {
        return $this->send(new EntrepriseRequest(
            siret: $siret
        ));
    }
}
