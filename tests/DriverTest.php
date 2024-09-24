<?php

namespace App\Tests;

use App\Entity\Driver;
use App\Repository\DriverRepository;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class DriverTest extends KernelTestCase
{
    private ?DriverRepository $driverRepository;

    protected function setUp(): void
    {
        parent::setUp();

        // Boot the kernel and get the entity manager
        self::bootKernel();
        $container = static::getContainer();

        // Purge the database before each test
        $this->driverRepository = $container->get(DriverRepository::class);
        $entityManager = $container->get('doctrine')->getManager();
       /* $purger = new ORMPurger($entityManager);
        $purger->purge();*/

    }

    public function testDatabaseInteraction(): void
    {
        //dd($this->driverRepository);
        $user = $this->driverRepository->find(101);

        //dd($user);
        $this->assertNotNull($user);
    }


    public function testFindAllDriversPage() : void
    {
         //dd($this->driverRepository);
         $drivers = $this->driverRepository->findByName(1, 10);

         $this->assertNotEmpty($drivers);
    }

}