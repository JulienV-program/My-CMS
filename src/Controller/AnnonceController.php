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
        $carrousel = $carrouselRepository->findAll();
        $photo = $imagesRepository->findAll();
        return $this->render('annonce/index.html.twig', [
            'puppys' => $puppys,
            'carrousel' => $carrousel,
            'photo' => $photo
        ]);
    }
}
