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


class UpdateVoters extends Controller
{
    /**
     * @Route("/update_voters", name="update_voters")
     */
    public function updateVoteAction(Request $request){
        if($request->isXmlHttpRequest())
        {
            new JsonResponse('final success');
        }
    }
}