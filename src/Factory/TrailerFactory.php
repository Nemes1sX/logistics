<?php

namespace App\Factory;

use App\Entity\Trailer;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Symfony\Component\String\ByteString;
use Carbon\Carbon;

/**
 * @extends PersistentProxyObjectFactory<Trailer>
 */
final class TrailerFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Trailer::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        $status = ['Works', 'Free', 'Downtime'];

        return [
            'createdAt' => \DateTimeImmutable::createFromMutable(Carbon::now()),
            'fleet_set' => FleetSetFactory::new(),
            'name' => ByteString::fromRandom(8),
            'status' => self::faker()->randomElement($status),
            'updatedAt' => \DateTimeImmutable::createFromMutable(Carbon::now()),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Trailer $trailer): void {})
        ;
    }
}
