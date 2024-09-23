<?php

namespace App\Factory;

use App\Entity\FleetSet;
use Carbon\Carbon;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<FleetSet>
 */
final class FleetSetFactory extends PersistentProxyObjectFactory
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
        return FleetSet::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'createdAt' => \DateTimeImmutable::createFromMutable(Carbon::now()),
            'name' => sprintf('Fs no. %03d', self::faker()->numberBetween(1, 9999)),
            'updatedAt' => \DateTimeImmutable::createFromMutable(Carbon::now()),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(FleetSet $fleetSet): void {})
        ;
    }
}
