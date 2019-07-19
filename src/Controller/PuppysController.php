<?php

namespace App\Controller;

use App\Entity\Puppys;
use App\Form\PuppysType;
use App\Repository\PuppysRepository;
use App\Repository\ImagesRepository;
use App\Repository\CarrouselRepository;
use App\Entity\Carrousel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


/**
 * @Route("/puppys")
 */
class PuppysController extends AbstractController
{
    /**
     * @Route("/", name="puppys_index", methods={"GET"})
     */
    public function index(PuppysRepository $puppysRepository): Response
    {
        return $this->render('puppys/index.html.twig', [
            'puppys' => $puppysRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="puppys_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $puppy = new Puppys();
        $form = $this->createForm(PuppysType::class, $puppy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carrousel = new Carrousel();
            $puppy->setCarrousel($carrousel);
            $puppy->setPostedAt(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($puppy);
            $entityManager->flush();

            return $this->redirectToRoute("puppys_edit", ['id' => $puppy->getId()]);
        }

        return $this->render('puppys/new.html.twig', [
            'puppy' => $puppy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="puppys_show", methods={"GET"})
     */
    public function show(Puppys $puppy, CarrouselRepository $carrouselRepository, ImagesRepository $imagesRepository): Response
    {
        $carrousel = $carrouselRepository->find($puppy->getCarrousel()->getId());
        $images = $imagesRepository->findBy(['carrousel' => $carrousel]);
        return $this->render('puppys/show.html.twig', [
            'puppy' => $puppy,
            'carrousel' => $carrousel,
            'images' => $images,
            'galeryId' => $carrousel->getId(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="puppys_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Puppys $puppy, CarrouselRepository $carrouselRepository, ImagesRepository $imagesRepository): Response
    {
        $carrousel = $carrouselRepository->find($puppy->getCarrousel()->getId());
        $images = $imagesRepository->findBy(['carrousel' => $carrousel]);

        $form = $this->createForm(PuppysType::class, $puppy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('puppys_index', [
                'id' => $puppy->getId(),
            ]);
        }

        return $this->render('puppys/edit.html.twig', [
            'puppy' => $puppy,
            'form' => $form->createView(),
            'carrousel' => $carrousel,
            'images' => $images,
            'galeryId' => $carrousel->getId(),
        ]);
    }
    /**
     *  @Route("/{id}/get", name="puppy_get", methods={"GET"})
     */
    public function puppyGet(Request $request, Puppys $puppys)
    {

        $normalizer = new ObjectNormalizer();

//        $normalizer->setIgnoredAttributes(['carrousel']);
        dump($normalizer);
        $encoder = new JsonEncoder();

        $serializer = new Serializer([$normalizer], [$encoder]);


//        $response = $serializer->serialize($page, 'json');
        $response = $serializer->serialize($puppys, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new Response($response);
    }
    /**
     * @Route("/{id}", name="puppys_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Puppys $puppy, CarrouselRepository $carrouselRepository, ImagesRepository $imageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$puppy->getId(), $request->request->get('_token'))) {
            $carrousel = $carrouselRepository->findOneBy(['id' => $puppy->getCarrousel()->getId()]);

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
            $entityManager->remove($puppy);
            $entityManager->remove($carrousel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('annonce');
    }
}
