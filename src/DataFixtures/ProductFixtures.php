<?php

namespace App\DataFixtures;

use App\Entity\Paper;
use App\Entity\Pen;
use App\Entity\Pencil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $pencil = new Pencil('Blue');
        $pencil->setSku(100);
        $pencil->setPrice(10.50);
        $pencil->setBrand($this->getReference('brand_1'));
        $manager->persist($pencil);

        $pencil2 = new Pencil('Red');
        $pencil2->setSku(101);
        $pencil2->setPrice(11);
        $pencil2->setBrand($this->getReference('brand_2'));
        $manager->persist($pencil2);

        $paper = new Paper('A4');
        $paper->setSku(102);
        $paper->setPrice(2.25);
        $paper->setBrand($this->getReference('brand_3'));
        $manager->persist($paper);

        $pen = new Pen('Ink');
        $pen->setSku(103);
        $pen->setPrice(20);
        $pen->setBrand($this->getReference('brand_1'));
        $manager->persist($pen);

        $manager->flush();
    }
}
