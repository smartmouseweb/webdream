<?php

namespace App\Entity;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Pen extends Product
{
    private ?string $type = null;

    public function __construct(?string $type = null)
    {
        $this->setName('Pen');

        if (isset($type)) {
            $this->setParameter($type);
            $this->setType($type);
        }
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }
}