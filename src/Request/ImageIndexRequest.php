<?php

namespace App\Request;

class ImageIndexRequest
{
    public function __construct(private ?string $name = null, private ?int $discountPercentage = null)
    {
    }

    public function getDiscountPercentage(): ?int
    {
        return $this->discountPercentage;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}