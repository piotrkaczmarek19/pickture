<?php

namespace ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteController extends Controller
{
    /**
     * @Route("/delete", name="delete_route")
     *
     */
    public function deleteAction(Request $request)
    {
        if($request->isXmlHttpRequest()){
            $image_id =json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();
            $em->getRepository('PublicBundle:Image')->deleteImage($image_id);
            return new JsonResponse('success');
        }

    }
}
