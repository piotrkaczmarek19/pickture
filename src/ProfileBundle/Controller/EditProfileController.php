<?php

namespace ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use PublicBundle\Entity\User;
use ProfileBundle\Form\Type\EditUserType;
use Symfony\Component\HttpFoundation\Request;

class EditProfileController extends Controller
{
    /**
     * @Route("/edit", name="edit_profile")
     */
    public function editProfileAction(Request $request)
    {
        // Getting user info
        $user_token= $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user_token->getId();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('PublicBundle:User')->find($user_id);
        
        $form = $this->createForm(EditUserType::class, $user);
        
        // Handling form
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $new_info = $form->getData();

            // Encoding password
            $password = $this->get('security.password_encoder')
                ->encodePassword($new_info, $new_info->getPlainPassword());
            $new_info->setPassword($password);
            
            $em->persist($new_info);
            $em->flush();
            return $this->redirectToRoute('homepage_profile');
        }
        return $this->render('ProfileBundle:Home:editProfile.html.twig', array('user'=>$user, 'edit_form'=>$form->createView()));
    }
}
