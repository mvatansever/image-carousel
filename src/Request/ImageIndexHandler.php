<?php

namespace App\Request;

use App\Service\ImageFilterService;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ImageIndexHandler
{
    public function __construct(
        private ImageFilterService $filterService,
        private ParameterBagInterface $params,
    )
    {

    }

    public function __invoke(ImageIndexRequest $imageIndexRequest)
    {
        $result = $this->filterService->filter(
            $this->getFilePath(),
            $imageIndexRequest->getName(),
            $imageIndexRequest->getDiscountPercentage(),
        );

        echo json_encode($result);die;

        return $result;
    }

    private function getFilePath(): string
    {
        return sprintf('%s/%s/%s', $this->params->get('kernel.project_dir'), 'data', 'latest.csv');
    }
}