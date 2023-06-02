<?php

namespace App\Controller;

use App\Request\ImageIndexHandler;
use App\Request\ImageIndexRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    #[Route('/image', name: 'image_index', methods: ['GET'])]
    #[ParamConverter('imageIndex', class: "App\Request\ImageIndexRequest")]
    public function index(ImageIndexRequest $imageIndex, ImageIndexHandler $handler): JsonResponse
    {
        return $this->json($handler($imageIndex));
    }
}