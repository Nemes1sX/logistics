<?php

namespace App\DataFixtures;

use App\Entity\Truck;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TruckFixture extends Fixture
{
    public const FLEET_SET_REFERENCE = 'fleet-set-';

    public function load(ObjectManager $manager): void
    {
        $manufcturer = ['DAF', 'Scania', 'Iveco'];
        $model = ['DAS', 'MAK', 'FAG', 'LAF', 'NEO'];

        for ($i=1; $i<=40; $i++) {
            $truck = new Truck();
            $truck->setManufacturer(array_rand($manufcturer));
            $truck->setModel(array_rand($model));

            $randomFleetSetRefrence = 'fleet-set-' . rand(1, 20);
            $fleetSet = $this->getReference($randomFleetSetRefrence);

            $truck->setFleetSet($fleetSet);
            $manager->persist($truck);
        }
        

        $manager->flush();
    }

    public function getDependecies(): array
    {
        return [
            FleetSetFixture::class
        ];       
    }
}
