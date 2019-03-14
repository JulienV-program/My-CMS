<?php

namespace App\Controller;

use App\Repository\CarrouselRepository;
use App\Repository\ImagesRepository;
use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GaleryController extends AbstractController
{
    /**
     * @Route("/galery", name="galery")
     */
    public function index(ImagesRepository $imagesRepository, CarrouselRepository $carrouselRepository, PageRepository $pageRepository)
    {

        $page = $pageRepository->findOneBy(['PageName' => 'Galerie']);
        dump($page);

        $carrousel = $carrouselRepository->findAll();
        $photo = $imagesRepository->findAll();
        return $this->render('galery/index.html.twig', [
            'photo' => $photo,
            'page' => $page,
            'carrousel' => $carrousel
        ]);
    }
}
