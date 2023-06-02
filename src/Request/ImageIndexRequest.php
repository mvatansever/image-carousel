<?php

namespace App\Request;

class ImageIndexRequest
{
    public function __construct(private ?int $discountPercentage = null, private ?string $name = null)
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