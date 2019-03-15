<?php

namespace App\Controller;

use App\Repository\CarrouselRepository;
use App\Repository\ImagesRepository;
use App\Repository\PuppysRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonce", name="annonce")
     */
    public function index(PuppysRepository $puppysRepository, CarrouselRepository $carrouselRepository, ImagesRepository $imagesRepository)
    {
        $puppys = $puppysRepository->findAll();

        $carrousel = [];
        foreach ($puppys as $item){
            $carrousel[] = $item->getCarrousel();
        }
        $photo = [];
        foreach ($carrousel as $item){
            $photo[] = $imagesRepository->findBy(['carrousel' => $item]);
        }

        return $this->render('annonce/index.html.twig', [
            'puppys' => $puppys,
            'carrousel' => $carrousel,
            'photo' => $photo
        ]);
    }
}
