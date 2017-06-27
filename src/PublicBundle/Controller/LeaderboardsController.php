<?php

namespace PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use PublicBundle\Form\Type\BrowseType;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class LeaderboardsController extends Controller
{
    /**
     * @Route("/leaderboards", name="leaderboards_route")
     */
    public function leaderboardsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $images = $em->getRepository('PublicBundle:Image')->getImagesByPopularity(-1);

        return $this->render('PublicBundle:Content:leaderboards.html.twig', array('images'=>$images));
    }

}
