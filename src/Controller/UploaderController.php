<?php

namespace App\Controller;

use App\Entity\Carrousel;
use App\Entity\Images;
use App\Entity\User;
use App\Form\ImageType;
use App\Repository\CarrouselRepository;
use App\Repository\DogsRepository;
use App\Repository\ImagesRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class UploaderController extends AbstractController
{
    /**
     * @Route("/uploader", name="uploader")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(CarrouselRepository $repository, DogsRepository $dogsRepository)
    {
        $carrousel = $repository->findAll();
        $dogs = $dogsRepository->findAll();

        return $this->render('uploader/index.html.twig', [
            'controller_name' => 'UploaderController',
            'carrousel' => $carrousel,
            'dogs' => $dogs
        ]);
    }

    /**
     * @Route("/uploaderCarrousel/carrousel-{id}", name="uploader_carrousel")
     */
    public function uploaderGaleries(CarrouselRepository $repository, $id, ImagesRepository $imagerepository)
    {

        $image = $imagerepository->findBy(['carrousel' => $id]);


        return $this->render('uploader/upload.html.twig', [
            'controller_name' => 'UploaderController',
            'images' => $image,
            'galeryId' => $id,
        ]);
    }

    /**
     * @Route("/{id}", name="photo_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Images $image): Response
    {
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $fileSystem = new Filesystem();
            $file = $image->getPath();
            $file = substr($file, 1);
            $fileSystem->remove([$file]);
            $entityManager->remove($image);
            $entityManager->flush();
            $id = $image->getCarrousel()->getId();
            dump($id);
        }

        return $this->redirectToRoute('uploader_carrousel', ['id' => $id]);
    }

    /**
     * @Route("/new", name="photo_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $image = new Images();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('photo_index');
        }

        return $this->render('photo/new.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("G/{id}", name="galerie_delete", methods={"DELETE"})
     */
    public function galeryDelete(Request $request, Carrousel $carrousel, UserRepository $userRepository, ImagesRepository $imageRepository, $id): Response
    {

        if ($this->isCsrfTokenValid('delete'.$carrousel->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();

            //supprimer les photos de la galerie
            $photos = $imageRepository->findBy(['carrousel' => $carrousel]);
            foreach ($photos as $photo){
                $entityManager = $this->getDoctrine()->getManager();
                $fileSystem = new Filesystem();
                $file = $photo->getPath();
                $file = substr($file, 1);
                $fileSystem->remove([$file]);
                $entityManager->remove($photo);
            }

            //supprimer la galerie dans l'user
            $users = $userRepository->findoneBy(['Galery' => $carrousel]);
            if (!is_null($users) ){
                $carrousel->removeUser($users);
            }

            //supprimer la galerie
            $entityManager->remove($carrousel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('uploader');

    }







}
