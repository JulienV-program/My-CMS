<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DogsPresentationController extends AbstractController
{
    /**
     * @Route("/presentation", name="dogs_presentation")
     */
    public function index()
    {
        return $this->render('dogs_presentation/index.html.twig', [
            'controller_name' => 'DogsPresentationController',
        ]);
    }
}
