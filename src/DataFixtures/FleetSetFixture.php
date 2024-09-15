<?php

namespace App\DataFixtures;

use App\Entity\FleetSet;
use App\Entity\Driver;
use App\Entity\Trailer;
use App\Entity\Truck;
use App\Factory\DriverFactory;
use App\Factory\FleetSetFactory;
use App\Factory\OrderFactory;
use App\Factory\TrailerFactory;
use App\Factory\TruckFactory;
use Symfony\Component\String\ByteString;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FleetSetFixture extends Fixture
{
    //public const FLEET_SET_REFERENCE = 'fleet-set-';


    public function load(ObjectManager $manager): void
    {
        /*$faker = Factory::create();
        $status = ['Works', 'Free', 'Downtime'];
        $manufcturer = ['DAF', 'Scania', 'Iveco'];
        $model = ['DAS', 'MAK', 'FAG', 'LAF', 'NEO'];

        for ($i=1; $i<=50; $i++) {
            $fleetSet = new FleetSet();
            $fleetSet->setName(sprintf("%03d", $i));
            $manager->persist($fleetSet);
            //$this->addReference(self::FLEET_SET_REFERENCE .$i, $fleetSet);
            
            $driver = new Driver();
            $driver->setName($faker->name());
            $manager->persist($driver);
            $driver->setFleetSet($fleetSet);


            $trailer = new Trailer();
            $trailer->setName(ByteString::fromRandom(8));
            $trailer->setStatus(array_rand($status));*/

            /*$randomFleetSetRefrence = 'fleet-set-' . rand(1, 20);
            $fleetSet = $this->getReference($randomFleetSetRefrence);*/


           /* $truck = new Truck();
            $truck->setManufacturer(array_rand($manufcturer));
            $truck->setModel(array_rand($model));
            $truck->setStatus(array_rand($status));
            
        }

        $manager->flush()*/
        /*$drivers = DriverFactory::createMany(100);
        $trailers = TrailerFactory::createMany(50);
        $trucks = TruckFactory::createMany(50);*/

        $fleetSets = FleetSetFactory::createMany(50, function() {
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
