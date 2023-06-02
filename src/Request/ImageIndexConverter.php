<?php

namespace App\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class ImageIndexConverter implements ParamConverterInterface
{
    private const
        NAME = 'name',
        DISCOUNT_PERCENTAGE = 'discount_percentage';

    public function apply(Request $request, ParamConverter $configuration)
    {
        $imageIndexRequest = new ImageIndexRequest($request->get(self::NAME, null), $request->get(self::DISCOUNT_PERCENTAGE, null));

        $request->attributes->set($configuration->getName(), $imageIndexRequest);

        return true;
    }

    public function supports(ParamConverter $configuration)
    {
        return $configuration->getName() === "imageIndex";
    }
}