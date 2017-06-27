<?php

namespace ProfileBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use PublicBundle\Entity\Image;


class UploadImage
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();


        if(!$entity instanceof Image){
            return;
        }

        $entity->setScore(0);

        $entity->setCreatedValue();
    }
}