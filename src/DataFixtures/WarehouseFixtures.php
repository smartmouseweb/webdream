<?php

namespace App\DataFixtures;

use App\Entity\Warehouse;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WarehouseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $warehouse = new Warehouse();
        $warehouse->setName('Rabbit Hole');
        $warehouse->setAddress('str. Alice, nr. 13, Wonderland');
        $warehouse->setCapacity('10');
        $manager->persist($warehouse);

        $warehouse2 = new Warehouse();
        $warehouse2->setName('Sesame');
        $warehouse2->setAddress('str. Alibaba, nr. 1001, Arabian Desert');
        $warehouse2->setCapacity('40');
        $manager->persist($warehouse2);

        $warehouse3 = new Warehouse();
        $warehouse3->setName('Dwarf house');
        $warehouse3->setAddress('str. Snow White, nr. 2, Magical Forest');
        $warehouse3->setCapacity('7');
        $manager->persist($warehouse3);

        $manager->flush();
    }
}
