<?php

namespace App\Factory;

use App\Entity\Order;
use Carbon\Carbon;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Order>
 */
final class OrderFactory extends PersistentProxyObjectFactory
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
        return Order::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        $status = ['To deliver', 'In progress', 'Done'];

        return [
            'createdAt' => \DateTimeImmutable::createFromMutable(Carbon::now()),
            'name' => sprintf('Fs no. %03d', self::faker()->numberBetween(1, 9999)),
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
            // ->afterInstantiate(function(Order $order): void {})
        ;
    }
}
