<?php

namespace App\DataFixtures;

use App\Entity\FleetSet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FleetSetFixture extends Fixture
{
    public const FLEET_SET_REFERENCE = 'fleet-set-';


    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=20; $i++) {
            $fleetSet = new FleetSet();
            $fleetSet->setName(sprintf("%03d", $i));
            $manager->persist($fleetSet);
            $this->addReference(self::FLEET_SET_REFERENCE .$i, $fleetSet);
        }

        $manager->flush();
    }
}
