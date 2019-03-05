<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 24/01/19
 * Time: 15:43
 */

namespace App\EventListener;


use App\Entity\Carrousel;
use App\Entity\Images;
use Doctrine\Common\Persistence\ObjectManager;
use Oneup\UploaderBundle\Event\PostPersistEvent;



class UploadListener
{
    /**
     * @var ObjectManager
     */
    private $om;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function onUpload(PostPersistEvent $event)
    {
        $adress = null;
        $request = $event->getRequest();
        $gallery = $this->om->getRepository(Carrousel::class);

        //recuperation id passer en get
        $id = $request->query->get('id');


            $num_galerie = $gallery->findOneBy(['id' => $id]);
            $file = $event->getFile();

            $photo = (new Images())
                ->setPath('/uploads/'.$file->getFilename())
                ->setCarrousel($num_galerie)
            ;


            $this->om->persist($photo);
            $this->om->flush();

            //if everything went fine
            $response = $event->getResponse();
            $response['success'] = true;
            return $response;


        $response = $event->getResponse();
        $response['success'] = false;
        return $response;


    }
}

