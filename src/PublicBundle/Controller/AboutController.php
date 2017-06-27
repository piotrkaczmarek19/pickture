<?php

namespace PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AboutController extends Controller
{
    /**
     * @Route("/about", name="about_route")
     */
    public function aboutAction()
    {
        return $this->render('PublicBundle:Content:about.html.twig');
    }
}