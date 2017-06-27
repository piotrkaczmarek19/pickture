<?php

namespace ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage_profile")
     */
    public function indexAction()
    {
        // Getting user images
        $user_token= $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user_token->getId();
        $em = $this->getDoctrine()->getManager();
        $images = $em->getRepository('PublicBundle:User')->find($user_id)->getImages();
        return $this->render('ProfileBundle:Home:index.html.twig', array('images'=>$images));
    }
}
