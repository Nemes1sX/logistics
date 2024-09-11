<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Trailer;
use Symfony\Component\String\ByteString;

class TrailerFixture extends Fixture
{
    public const FLEET_SET_REFERENCE = 'fleet-set-';


    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=100; $i++) {
            $trailer = new Trailer();
            $trailer->setName(ByteString::fromRandom(8));

            $randomFleetSetRefrence = 'fleet-set-' . rand(1, 20);
            $fleetSet = $this->getReference($randomFleetSetRefrence);
            $trailer->setFleetSet($fleetSet);

            $manager->persist($trailer);
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
