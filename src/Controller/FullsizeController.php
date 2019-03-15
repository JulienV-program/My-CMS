<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CarrouselRepository;
use App\Repository\ImagesRepository;
use App\Repository\PageRepository;

class FullsizeController extends AbstractController
{
    /**
     * @Route("/fullsize", name="fullsize")
     */
    public function index(ImagesRepository $imagesRepository, CarrouselRepository $carrouselRepository, PageRepository $pageRepository)
    {
        $title = $_GET['title'];
        dump($title);
        $page = $pageRepository->findOneBy(['PageName' => 'Galerie']);
        dump($page);

        $carrousel= $carrouselRepository->findByPage($page);

        $photo = [];
        foreach ($carrousel as $item){
            $photo[] = $imagesRepository->findBy(['carrousel' => $item]);
        }

        return $this->render('fullsize/index.html.twig', [
            'path' => $title ,
            'photo' => $photo,
            'page' => $page,
            'carrousel' => $carrousel]);
    }
}
