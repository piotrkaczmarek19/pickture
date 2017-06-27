<?php

namespace PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use PublicBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="public_home")
     */
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
        return $this->render('PublicBundle:Content:index.html.twig');
    }
}
