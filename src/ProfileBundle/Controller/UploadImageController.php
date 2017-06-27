<?php

namespace ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use PublicBundle\Entity\Image;
use PublicBundle\Entity\Face;
use PublicBundle\Entity\Tag;
use ProfileBundle\Form\Type\ImageType;

class UploadImageController extends Controller
{
    /**
     * @Route("/upload", name="upload_route")
     */
    public function uploadAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // Retrieving current user
        $user_token= $this->get('security.token_storage')->getToken()->getUser();
        $id = $user_token->getId();
        $user = $em->getRepository('PublicBundle:User')->find($id);

        // Handling Form
        $image = new Image();


        $form =  $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);
        if($form->isValid()){
            $image->setUser($user);

            $image->upload();
            // Making request to API
            //$im_url = $entity->getPath();
            $im_url = "http://images.myhtcwallpaper.com/Gallery/7_People/My-htc-one-wallpaper-Celebrities_40.jpg"; // for local testing only
            $url = "https://visurec.herokuapp.com/?url=".$im_url;
            $out = file_get_contents($url);
            $out = json_decode($out, true);
            // Saving Results
            // Saving width and height of image
            $im_width = $out["width"];
            $im_height = $out["height"];
            $image->setImWidth($im_height);
            $image->setImHeight($im_height);
            // Saving faces and setting up one to mnay relation with image
            if (!empty($out['faces'] && $out['status'] == 1))
            {
                foreach ($out['faces'] as $result)
                {
                    $face = New Face();
                    $x = ($result[0] / $im_width) * 100;
                    $y = ($result[1] / $im_height) * 100;
                    $f_width = ($result[2] / $im_width) * 100;
                    $f_height = ($result[3] / $im_height) * 100;
                    $face->setX($x);
                    $face->setY($y);
                    $face->setWidth($f_width);
                    $face->setHeight($f_height);
                    $face->setImage($image);
                    $em->persist($face);
                }
            }
            $em->persist($image);
            $em->flush();

            return $this->redirectToRoute("homepage_profile");
        }
        return $this->render('ProfileBundle:Upload:uploadImage.html.twig', array('form'=>$form->createView(), 'user'=>$user));
    }
}
