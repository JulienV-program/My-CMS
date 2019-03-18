<?php

namespace App\Controller;

use App\Repository\PageRepository;
use App\Repository\CarrouselRepository;
use App\Repository\ImagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(PageRepository $pageRepository, CarrouselRepository $carrouselRepository, ImagesRepository $imagesRepository)
    {
        $page = $pageRepository->findOneBy(['PageName' => 'Contact']);
        $carrousel= $carrouselRepository->findByPage($page);

        $photo = [];
        foreach ($carrousel as $item){
            $photo[] = $imagesRepository->findBy(['carrousel' => $item]);
        }
        return $this->render('contact/index.html.twig', [
            'page' => $page,
            'carrousel' => $carrousel,
            'photo' => $photo
        ]);
    }
}
