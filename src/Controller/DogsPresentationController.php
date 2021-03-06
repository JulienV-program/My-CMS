<?php

namespace App\Controller;

use App\Repository\CarrouselRepository;
use App\Repository\DogsRepository;
use App\Repository\ImagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DogsPresentationController extends AbstractController
{
    /**
     * @Route("/presentation", name="dogs_presentation")
     */
    public function index(DogsRepository $dogsRepository, CarrouselRepository $carrouselRepository, ImagesRepository $imagesRepository)
    {
        $dogs = $dogsRepository->findAll();
        $carrousel = [];
        foreach ($dogs as $item){
            $carrousel[] = $item->getCarrousel();
        }
        $photo = [];
        foreach ($carrousel as $item){
            $photo[] = $imagesRepository->findBy(['carrousel' => $item]);
        }

        return $this->render('dogs_presentation/index.html.twig', [
            'dogs' => $dogs,
            'carrousel' => $carrousel,
            'photo' => $photo
        ]);
    }
}
