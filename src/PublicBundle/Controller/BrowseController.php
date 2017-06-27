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


class BrowseController extends Controller
{
    /**
     * @Route("/browse", name="browse_route")
     */
    public function browseAction(Request $request)
    {
        $form = $this->createForm(BrowseType::class);

        return $this->render('PublicBundle:Content:browse.html.twig', array('form'=>$form->createView()));
    }

    /**
    * @Route("/browse_process", name="browse_process_route")
    */
    public function browseProcessAction(Request $request)
    {
        // Settting up serializer for sending data after AJAX call
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        if($request->isXmlHttpRequest())
        {
            $data = $request->request->get('browse');
            $em = $this->getDoctrine()->getManager();
            $images=[];
            // Search by tag
            if(isset($data['tag']))
            {
                $tag = $data['tag'];
                $images = $em->getRepository('PublicBundle:Image')->getImagesByTag($tag);
            }
            // search by user
            else if(isset($data['user']))
            {
                $username = $data['user'];
                $results = $em->getRepository('PublicBundle:User')->loadImagesFromUsers($username);
                if (isset($results))
                {
                    $images = $results; 
                }    
                else
                {
                    $response = "nothing found";
                }
            }
            // search by date
            else if(isset($data['created']))
            {
                switch($data['created'])
                {
                    case 'week':
                        $interval = date('Y-m-d H:i:s', strtotime('-1 month'));
                        break;
                    case 'month':
                        $interval = date('Y-m-d H:i:s', strtotime('-1 year'));
                        break;
                    case 'always':
                        $interval = date("Y-m-d H:i:s", strtotime('-10 years'));
                }
                $images = $em->getRepository('PublicBundle:Image')->getImagesBySubmitDate($interval);
            }

            // building response 
            if(sizeof($images) > 0){
                for($i=0;$i<sizeof($images);$i++){
                    $response[$i]['id']=$images[$i]->getId();
                    $response[$i]['path']='/uploads/documents/'.$images[$i]->getPath();
                    $response[$i]['user']=$images[$i]->getUser()->getUsername();
                }
            }
            else
            {
                $response = "No images found";
            }
            return new JsonResponse($response);
        }
    }
}
