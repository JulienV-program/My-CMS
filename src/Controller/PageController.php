<?php

namespace App\Controller;

use App\Entity\Page;
use App\Entity\Carrousel;
use App\Form\PageType;
use App\Repository\PageRepository;
use App\Repository\ImagesRepository;
use App\Repository\CarrouselRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @Route("/page")
 */
class PageController extends AbstractController
{
    /**
     * @Route("/", name="page_index", methods={"GET"})
     */
    public function index(PageRepository $pageRepository): Response
    {
        return $this->render('page/index.html.twig', [
            'pages' => $pageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="page_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $page = new Page();
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carrousel = new Carrousel();
            $carrousel->addPage($page);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($page);
            $entityManager->persist($carrousel);
            $entityManager->flush();

            return $this->redirectToRoute('page_edit', ['id' => $page->getId()]);
        }

        return $this->render('page/new.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="page_show", methods={"GET"})
     */
    public function show(Page $page, CarrouselRepository $carrouselRepository, ImagesRepository $imagesRepository): Response
    {
        $carrousel = $page->getCarrousel();
        $images = [];
        foreach ($carrousel as $item){
            $images += $imagesRepository->findBy(['carrousel' => $item->getId()]);

        }

        return $this->render('page/show.html.twig', [
            'page' => $page,
            'carrousel' => $carrousel,
            'images' => $images,
        ]);
    }

    /**
     *  @Route("/{id}/get", name="pages_get", methods={"GET"})
     */
    public function pageGet(Request $request, Page $page, CarrouselRepository $carrouselRepository, ImagesRepository $imagesRepository)
    {

        $normalizer = new ObjectNormalizer();
        dump($page);
//        $normalizer->setIgnoredAttributes(['carrousel']);
        dump($normalizer);
        $encoder = new JsonEncoder();

        $serializer = new Serializer([$normalizer], [$encoder]);


//        $response = $serializer->serialize($page, 'json');
        $response = $serializer->serialize($page, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new Response($response);
    }

    /**
     * @Route("/{id}/edit", name="page_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Page $page, $id, CarrouselRepository $carrouselRepository, ImagesRepository $imagesRepository): Response
    {
        dump($_POST);

        $carrousel = $page->getCarrousel();
        $images = [];
        foreach ($carrousel as $item){
        $images += $imagesRepository->findBy(['carrousel' => $item->getId()]);

    }

        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('page_index', [
                'id' => $page->getId(),
            ]);
        }

        return $this->render('page/edit.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
            'carrousel' => $carrousel,
            'images' => $images,
//            'galeryId' => $carrousel->getId(),
        ]);
    }

    /**
     * @Route("/{id}", name="page_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Page $page, CarrouselRepository $carrouselRepository, ImagesRepository $imagesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$page->getId(), $request->request->get('_token'))) {
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
            $entityManager->remove($page);
            $entityManager->flush();
        }

        return $this->redirectToRoute('page_index');
    }
}
