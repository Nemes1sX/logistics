<?php

namespace App\DataFixtures;

use App\Entity\Driver;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class DriverFixture extends Fixture
{
    public const FLEET_SET_REFERENCE = 'fleet-set-';

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i=1; $i<=40; $i++) {
            $driver = new Driver();
            $driver->setName($faker->name());

            $randomFleetSetRefrence = 'fleet-set-' . rand(1, 20);
            $fleetSet = $this->getReference($randomFleetSetRefrence);

            $driver->setFleetSet($fleetSet);
            
            $manager->persist($driver);
        }
    }

     public function getDependecies(): array
    {
        return [
            FleetSetFixture::class
        ];       
    }
}