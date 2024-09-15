<?php

namespace App\DataFixtures;

use App\Factory\DriverFactory;
use App\Factory\FleetSetFactory;
use App\Factory\OrderFactory;
use App\Factory\TrailerFactory;
use App\Factory\TruckFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FleetSetFixture extends Fixture
{
    //public const FLEET_SET_REFERENCE = 'fleet-set-';


    public function load(ObjectManager $manager): void
    {
        $fleetSets = FleetSetFactory::createMany(50, function () {
        $drivers = DriverFactory::createMany(2);

            return [
                'trailer' => TrailerFactory::new(),
                'truck' => TruckFactory::new(),
                'drivers' => $drivers
            ];
        });
        OrderFactory::createMany(51, function () use ($fleetSets) {
            return [
                'fleetSet' => $fleetSets
            ];
        });
    }
}
