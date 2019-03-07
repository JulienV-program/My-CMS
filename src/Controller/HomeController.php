<?php

namespace App\Controller;

use App\Repository\PageRepository;
use App\Repository\CarrouselRepository;
use App\Repository\ImagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PageRepository $pageRepository, CarrouselRepository $carrouselRepository, ImagesRepository $imagesRepository)
    {
        $page = $pageRepository->findOneBy(['PageName' => 'Home']);

        $carrousel = $carrouselRepository->findAll();
        $photo = $imagesRepository->findAll();
        return $this->render('home/index.html.twig', [
            'page' => $page,
            'carrousel' => $carrousel,
            'photo' => $photo
        ]);
    }
}
