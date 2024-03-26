<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $brand = new Brand();
        $brand->setName('Water');
        $brand->setQuality(1);
        $manager->persist($brand);

        $brand2 = new Brand();
        $brand2->setName('Earth');
        $brand2->setQuality(3);
        $manager->persist($brand2);

        $brand3 = new Brand();
        $brand3->setName('Fire');
        $brand3->setQuality(5);
        $manager->persist($brand3);

        $manager->flush();

        $this->addReference('brand_1', $brand);
        $this->addReference('brand_2', $brand2);
        $this->addReference('brand_3', $brand3);
    }
}
