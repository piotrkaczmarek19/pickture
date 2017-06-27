<?php

namespace PublicBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use PublicBundle\Entity\User;

class JoinedOn
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if(!$entity instanceof User){
            return;
        }

        $entity->setJoinedValue();

        $entity->setIsActive(0);
    }
}