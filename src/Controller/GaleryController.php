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

        $carrousel= $carrouselRepository->findByPage($page);

        $photo = [];
        foreach ($carrousel as $item){
            $photo[] = $imagesRepository->findBy(['carrousel' => $item]);
        }

        return $this->render('galery/index.html.twig', [
            'photo' => $photo,
            'page' => $page,
            'carrousel' => $carrousel
        ]);
    }
}
