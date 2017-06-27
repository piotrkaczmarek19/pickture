<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use PublicBundle\Entity\User;

class DisplayUserAdminController extends Controller
{
    /**
     * @Route("/details/{user_id}",
     * defaults={"user": 0},
     * requirements={
	*	"user": "\w+"
     *},
     * name="display_user_admin")
     */
    public function DisplayUserAdminAction($user_id)
    {

    	$em = $this->getDoctrine()->getManager();
    	$user = $em->getRepository('PublicBundle:User')->find($user_id);
        return $this->render('AdminBundle:Default:display_user_admin.html.twig', array("user"=>$user));
    }
}
