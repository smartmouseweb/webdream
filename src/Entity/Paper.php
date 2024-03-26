<?php

namespace App\Entity;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Paper extends Product
{
    private ?string $size = null;

    public function __construct(?string $size = null)
    {
        $this->setName('Paper');

        if (isset($size)) {
            $this->setParameter($size);
            $this->setSize($size);
        }
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): static
    {
        $this->size = $size;

        return $this;
    }
}