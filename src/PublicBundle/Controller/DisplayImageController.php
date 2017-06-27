<?php

namespace PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use PublicBundle\Entity\Comment;
use PublicBundle\Entity\Image;
use PublicBundle\Entity\Face;
use PublicBundle\Entity\User;
use ProfileBundle\Form\Type\CommentType;
use PublicBundle\Form\Type\VoteType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DisplayImageController extends Controller
{
    /**
     * @Route("/pick/{image_id}",
     * defaults={"pick": 0},
     * requirements={
     *     "pick": "\d+"
     * },
     * name="display_image")
     */
    public function displayImageAction(Request $request, $image_id)
    {
        // Creating Form
        $comment = new Comment();
        $em = $this->getDoctrine()->getManager();
        $image = $em->getRepository('PublicBundle:Image')->find($image_id);
        $form =  $this->createForm(CommentType::class, $comment);
        $vote_form = $this->createForm(VoteType::class, $image);
        $out = null;

        if(0 == $image_id || !isset($image)){
            return $this->redirectToRoute('public_home');
        }

        $test = "false";
        // rendering and processing form only if authenticated
        if($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){

            // Retrieving current user
            $user_token= $this->get('security.token_storage')->getToken()->getUser();
            $id = $user_token->getId();

            $user = $em->getRepository('PublicBundle:User')->find($id);



            // Handling Form
            $form->handleRequest($request);
            if($form->isValid()){
                $comment->setUser($user);
                $comment->setImage($image);

                $em->persist($comment);
                $em->flush();
            }

            // Vote form

            $vote_form->handleRequest($request);
            if($vote_form->isValid()){
                $image->addVoter($user);
                $user->addImagesVoted($image);
                $em->persist($user);
                $em->flush();
                $em->getRepository('PublicBundle:Image')->UpdateScore(1, $image_id);
            }

            // Checking if user is uploader -- enabled by default for demo purposes
            /*
            // Checking if current user is uploader of current image
            $image_user = $image->getUser()->getId();
            if ($id == $image_user)
            {

                // Load up Python script for face recognition
                $root_dir = $this->get('kernel')->getRootDir().'/../web/';
                $image_name = $root_dir."uploads/documents/".$image->getPath();
                $path = __DIR__.'/../Python/predict.py';
                $process = new Process('python '.$path.' "'.$image_name.'" 2>&1');
                $process->run();
                $out = $process->getOutput();

                // remove parentheses as well as last whitespace to prevent empty array from being created at the end
                if (isset($out))
                {
                    $out = preg_replace('/[\(\)]|[\s]$/','',$out);
                    $out = explode("\n", $out);
                    foreach($out as $key=>$val)
                    {
                        $out[$key] = array_map("intval", explode(",", $val));

                        // Processing coordinates to get proportionnal position of pixels
                        $x_offset = ($out[$key][0] / $out[$key][4]) * 100;
                        $y_offset = ($out[$key][1] / $out[$key][5]) * 100;
                        $width = ($out[$key][2] / $out[$key][4]) * 100;
                        $height = ($out[$key][3] / $out[$key][5]) * 100;

                        $out[$key] = [$x_offset, $y_offset, $width, $height];
                    }
                    //$out = array_map('intval', explode(",", $out));
                }
            } */
        }


        // Face Recognition script activated by default for demo purposes
        // Load up Python script for face recognition
        $root_dir = $this->get('kernel')->getRootDir().'/../web/';
        $image_name = $root_dir."uploads/documents/".$image->getPath();
        
        // local python script - disabled in favor of heroku API
        /*
        $path = __DIR__.'/../Python/predict.py';
        $process = new Process('python '.$path.' "'.$image_name.'" 2>&1');
        $process->run();
        $out = $process->getOutput();

        // remove parentheses as well as last whitespace to prevent empty array from being created at the end
        if (isset($out))
        {
            $out = preg_replace('/[\(\)]|[\s]$/','',$out);
            $out = explode("\n", $out);
            foreach($out as $key=>$val)
            {
                $out[$key] = array_map("intval", explode(",", $val));

                // Processing coordinates to get proportionnal position of pixels
                $x_offset = ($out[$key][0] / $out[$key][4]) * 100;
                $y_offset = ($out[$key][1] / $out[$key][5]) * 100;
                $width = ($out[$key][2] / $out[$key][4]) * 100;
                $height = ($out[$key][3] / $out[$key][5]) * 100;

                $out[$key] = [$x_offset, $y_offset, $width, $height];
            }
            //$out = array_map('intval', explode(",", $out));
        }
        */

        // Retrieving comments  and detected faces for image
        $comments = $em->getRepository('PublicBundle:Comment')->getCommentsByImage($image_id);
        $faces = $image->getFaces();
        // Retrieving image url
        $url = $em->getRepository('PublicBundle:Image')->getImageUrl($image_id);
        return $this->render('PublicBundle:Content:displayImage.html.twig', array('form'=>$form->createView(),'image'=>$image, 'vote_form'=>$vote_form->createView(), 'comments'=>$comments, 'url'=>$url, 'faces'=>$faces));
    }
}