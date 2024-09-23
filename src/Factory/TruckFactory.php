<?php

namespace App\Factory;

use App\Entity\Truck;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Symfony\Component\String\ByteString;
use Carbon\Carbon;

/**
 * @extends PersistentProxyObjectFactory<Truck>
 */
final class TruckFactory extends PersistentProxyObjectFactory
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
        return Truck::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        $manufcturer = ['DAF', 'Scania', 'Iveco'];
        $model = ['DAS', 'MAK', 'FAG', 'LAF', 'NEO'];
        $status = ['Works', 'Free', 'Downtime'];

        return [
            'createdAt' => \DateTimeImmutable::createFromMutable(Carbon::now()),
            'fleet_set' => FleetSetFactory::new(),
            'license_plate' => ByteString::fromRandom(8),
            'manufacturer' => self::faker()->randomElement($manufcturer),
            'model' => self::faker()->randomElement($model),
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
            // ->afterInstantiate(function(Truck $truck): void {})
        ;
    }
}
