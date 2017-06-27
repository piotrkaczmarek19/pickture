<?php

namespace PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use PublicBundle\Entity\Comment;

class DisplayUserController extends Controller
{
    /**
     * @Route("/user/{user_id}",
     * defaults={"user": 0},
     * requirements={
     *     "user": "\w+"
     * },
     * name="display_user")
     */
    public function DisplayUserAction($user_id){
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('PublicBundle:User')->find($user_id);
        return $this->render('PublicBundle:Content:displayUser.html.twig', array('user'=>$user));
    }
}