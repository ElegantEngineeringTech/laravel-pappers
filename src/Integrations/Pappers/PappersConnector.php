<?php

namespace Elegantly\Pappers\Integrations\Pappers;

use Illuminate\Support\Facades\Cache;
use Saloon\CachePlugin\Contracts\Cacheable;
use Saloon\CachePlugin\Contracts\Driver;
use Saloon\CachePlugin\Drivers\LaravelCacheDriver;
use Saloon\CachePlugin\Traits\HasCaching;
use Saloon\Http\Auth\QueryAuthenticator;
use Saloon\Http\Connector;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;
use Saloon\RateLimitPlugin\Limit;
use Saloon\RateLimitPlugin\Stores\LaravelCacheStore;
use Saloon\RateLimitPlugin\Traits\HasRateLimits;

/**
 * @see documentation at https://www.pappers.fr/api/documentation#tag/Fiche-entreprise/operation/entreprise
 */
class PappersConnector extends Connector implements Cacheable
{
    use HasCaching;
    use HasRateLimits;

    public function __construct(
        public string $token,
        public string $version
    ) {
        $this->cachingEnabled = config('pappers.cache.enabled', true);
        $this->useRateLimitPlugin(config('pappers.rate_limit.enabled', false));
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
        return new LaravelCacheDriver(Cache::store(config('pappers.cache.driver', 'file')));
    }

    public function cacheExpiryInSeconds(): int
    {
        return config('pappers.cache.expiry_seconds', 86_400);
    }

    protected function resolveRateLimitStore(): RateLimitStore
    {
        return new LaravelCacheStore(Cache::store(config('pappers.rate_limit.driver', 'array')));
    }

    protected function resolveLimits(): array
    {
        return [
            Limit::allow(config('pappers.rate_limit.every_minute'))->everyMinute(),
        ];
    }
}
