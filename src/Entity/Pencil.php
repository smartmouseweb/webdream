<?php

namespace App\Entity;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Pencil extends Product
{
    private ?string $color = null;

    public function __construct(?string $color = null)
    {
        $this->setName('Pencil');

        if (isset($color)) {
            $this->setParameter($color);
            $this->setColor($color);
        }
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    } 
}