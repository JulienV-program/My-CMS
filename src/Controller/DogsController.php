<?php

namespace App\Controller;

use App\Entity\Carrousel;
use App\Entity\Dogs;
use App\Form\DogsType;
use App\Repository\CarrouselRepository;
use App\Repository\DogsRepository;
use App\Repository\ImagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;


/**
 * @Route("/dogs")
 */
class DogsController extends AbstractController
{
    /**
     * @Route("/", name="dogs_index", methods={"GET"})
     */
    public function index(DogsRepository $dogsRepository): Response
    {
        return $this->render('dogs/index.html.twig', [
            'dogs' => $dogsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="dogs_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $dog = new Dogs();
        $form = $this->createForm(DogsType::class, $dog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carrousel = new Carrousel();
            $dog->setCarrousel($carrousel);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dog);
            $entityManager->flush();

            return $this->redirectToRoute("dogs_edit", ['id' => $dog->getId()]);
        }

        return $this->render('dogs/new.html.twig', [
            'dog' => $dog,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dogs_show", methods={"GET"})
     */
    public function show(Dogs $dog, CarrouselRepository $carrouselRepository, ImagesRepository $imagesRepository): Response
    {
        $carrousel = $carrouselRepository->find($dog->getCarrousel()->getId());
        $images = $imagesRepository->findBy(['carrousel' => $carrousel]);
        return $this->render('dogs/show.html.twig', [
            'dog' => $dog,
            'carrousel' => $carrousel,
            'images' => $images,
            'galeryId' => $carrousel->getId(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="dogs_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Dogs $dog, CarrouselRepository $carrouselRepository, ImagesRepository $imagesRepository): Response
    {
        $carrousel = $carrouselRepository->find($dog->getCarrousel()->getId());
        $images = $imagesRepository->findBy(['carrousel' => $carrousel]);

        $form = $this->createForm(DogsType::class, $dog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dogs_index', [
                'id' => $dog->getId(),
            ]);
        }

        return $this->render('dogs/edit.html.twig', [
            'dog' => $dog,
            'form' => $form->createView(),
            'carrousel' => $carrousel,
            'images' => $images,
            'galeryId' => $carrousel->getId(),
        ]);
    }

    /**
     * @Route("/{id}", name="dogs_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Dogs $dog, CarrouselRepository $carrouselRepository, ImagesRepository $imageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dog->getId(), $request->request->get('_token'))) {
            $carrousel = $carrouselRepository->findOneBy(['id' => $dog->getCarrousel()->getId()]);

            $photos = $imageRepository->findBy(['carrousel' => $carrousel]);
            foreach ($photos as $photo){
                $entityManager = $this->getDoctrine()->getManager();
                $fileSystem = new Filesystem();
                $file = $photo->getPath();
                $file = substr($file, 1);
                $fileSystem->remove([$file]);
                $entityManager->remove($photo);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($dog);
            $entityManager->remove($carrousel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dogs_index');
    }
}
