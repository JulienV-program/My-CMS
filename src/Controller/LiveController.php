<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 26/03/19
 * Time: 15:48
 */

namespace App\Controller;

use App\Entity\Dogs;
use App\Entity\Images;
use App\Entity\Paragraph;
use App\Entity\Puppys;
use App\Repository\ImagesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/live/")
 */
class LiveController extends AbstractController
{

    /**
     * @Route("image/{id}/edit", name="image_edit", methods={"POST"})
     */
    public function description(Request $request ,ImagesRepository $imagesRepository, Images $images){
        dump($_POST);
        dump($request);
        $images->setDescription($_POST['content']);
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($images);
        $manager->flush();

        return $this->redirectToRoute('annonce');
    }

    /**
     * @Route("puppy/{id}/edit", name="puppy_edit", methods={"POST"})
     */
    public function setpuppy(Request $request, Puppys $puppys){
        dump($_POST);
        dump($request);
        $puppys->setDescription($_POST['body']);
        $puppys->setTitle($_POST['title']);
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($puppys);
        $manager->flush();

        return $this->redirectToRoute('annonce');
    }

    /**
     * @Route("paragraph/{id}/edit", name="paragraph_edit", methods={"POST"})
     */
    public function setParagraph(Request $request, Paragraph $paragraph){
        dump($_POST);
        $data = $_POST['data'];
        dump($data);
        $paragraph->setBody($data);
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($paragraph);
        $manager->flush();

        return $this->redirectToRoute('annonce');
    }

    /**
     * @Route("dog/{id}/edit-name", name="dog_edit", methods={"POST"})
     */
    public function setDogName(Request $request, Dogs $dogs){
        dump($_POST);
        $data = $_POST['data'];
        dump($data);
        $dogs->setName($data);
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($dogs);
        $manager->flush();

        return $this->redirectToRoute('annonce');
    }

    /**
     * @Route("dog/{id}/edit-description", name="dog_edit", methods={"POST"})
     */
    public function setDogDescription(Request $request, Dogs $dogs){
        dump($_POST);
        $data = $_POST['data'];
        dump($data);
        $dogs->setDescription($data);
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($dogs);
        $manager->flush();

        return $this->redirectToRoute('annonce');
    }

}