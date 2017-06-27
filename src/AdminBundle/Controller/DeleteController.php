<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AdminBundle\Utils\PasswordManager;

class DeleteController extends Controller
{
   /**
     * @Route("/delete")
     */
    public function deleteObjectFunction (Request $request)
    {
        // Settting up serializer for sending data after AJAX call
        $pwManager = PasswordManager::getInstance();
        return new JsonResponse($pwManager->getPass());
        // Verifying it is an xml request and that we have a correct token saved in browser
        if ($request->isXmlHttpRequest() && $pwManager->verifyPassword() && $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
        {
            $type = $request->request->get('type');
            $id = $request->request->get('id');
            $action = $request->request->get('action');
           
            $em = $this->getDoctrine()->getManager();
            // Choosing which action to perform
            if ($type == "image" && $action == "delete")
            {
                $em->getRepository("PublicBundle:Image")->deleteImage($id);
                return new JsonResponse("deleted");
            }
            else if ($type == "user" && $action == "ban")
            {
                $em->getRepository("PublicBundle:User")->banUser($id);
                return new JsonResponse("banned");
            }
            else if ($type == "user" && $action == "delete")
            {
                $em->getRepository("PublicBundle:User")->deleteUser($id);
                return new JsonResponse("deleted");                
            }
            else if ($type == "comment" && $action == "delete")
            {
                $em->getRepository("PublicBundle:Comment")->deleteComment($id);
                return new JsonResponse("deleted");                
            }
        }
    }
}