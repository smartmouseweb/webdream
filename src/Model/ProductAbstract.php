<?php

namespace App\ProductAbstract;

use App\Entity\Brand;

abstract class ProductAbstract
{
    protected ?int $id = null;
    protected ?string $name = null;
    protected ?string $sku = null;
    protected ?string $price = null;
    protected ?Brand $brand = null;

    protected function getId(): ?int
    {
        return $this->id;
    }

    protected function getName(): ?string
    {
        return $this->name;
    }

    protected function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    protected function getSku(): ?string
    {
        return $this->sku;
    }

    protected function setSku(string $sku): static
    {
        $this->sku = $sku;

        return $this;
    }

    protected function getPrice(): ?string
    {
        return $this->price;
    }

    protected function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    protected function getBrand(): ?Brand
    {
        return $this->brand;
    }

    protected function setBrand(?Brand $brand): static
    {
        $this->brand = $brand;

        return $this;
    }
}
