<?php

namespace App\Request;

class ImageIndexHandler
{
    public function __invoke(ImageIndexRequest $imageIndexRequest)
    {
        return [
            'name' => $imageIndexRequest->getName(),
        ];
    }
}