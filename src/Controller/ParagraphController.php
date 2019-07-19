<?php

namespace App\Controller;

use App\Entity\Paragraph;
use App\Form\ParagraphType;
use App\Repository\ParagraphRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @Route("/paragraph")
 */
class ParagraphController extends AbstractController
{
    /**
     * @Route("/", name="paragraph_index", methods={"GET"})
     */
    public function index(ParagraphRepository $paragraphRepository): Response
    {
        return $this->render('paragraph/index.html.twig', [
            'paragraphs' => $paragraphRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="paragraph_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $paragraph = new Paragraph();
        $form = $this->createForm(ParagraphType::class, $paragraph);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($paragraph);
            $entityManager->flush();

            return $this->redirectToRoute('paragraph_index');
        }

        return $this->render('paragraph/new.html.twig', [
            'paragraph' => $paragraph,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="paragraph_show", methods={"GET"})
     */
    public function show(Paragraph $paragraph): Response
    {
        return $this->render('paragraph/show.html.twig', [
            'paragraph' => $paragraph,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="paragraph_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Paragraph $paragraph): Response
    {
        $form = $this->createForm(ParagraphType::class, $paragraph);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('paragraph_index', [
                'id' => $paragraph->getId(),
            ]);
        }

        return $this->render('paragraph/edit.html.twig', [
            'paragraph' => $paragraph,
            'form' => $form->createView(),
        ]);
    }

    /**
     *  @Route("/{id}/get", name="paragraph_get", methods={"GET"})
     */
    public function paragraphGet(Request $request, Paragraph $paragraph)
    {

        $normalizer = new ObjectNormalizer();

//        $normalizer->setIgnoredAttributes(['carrousel']);
        dump($normalizer);
        $encoder = new JsonEncoder();

        $serializer = new Serializer([$normalizer], [$encoder]);


//        $response = $serializer->serialize($page, 'json');
        $response = $serializer->serialize($paragraph, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new Response($response);
    }

    /**
     * @Route("/{id}", name="paragraph_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Paragraph $paragraph): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paragraph->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($paragraph);
            $entityManager->flush();
        }

        return $this->redirectToRoute('paragraph_index');
    }
}
