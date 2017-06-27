<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use PublicBundle\Entity\User;
use AdminBundle\Utils\PasswordManager;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$users = $em->getRepository('PublicBundle:User')->findAll();
        return $this->render('AdminBundle:Default:index.html.twig', array("users"=>$users));
    }
}
