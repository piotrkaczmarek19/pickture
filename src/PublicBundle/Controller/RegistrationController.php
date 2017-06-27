<?php
namespace PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PublicBundle\Form\Type\UserType;
use PublicBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="user_registration")
     */
    public function registerAction(Request $request)
    {
        // Building form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // Handling request on POST
        $form->handleRequest($request);
        if($form->isvalid()) {
            // Encoding password
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // Encoding unique activation key
            $key = md5(rand(99999,200000));
            $user->setActivation($key);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // Sending activation mail goes here
            $email = $user->getEmail();
            $message = \Swift_Message::newInstance()
                ->setSubject('Activation')
                ->setFrom('noreply@pickture.info')
                ->setTo($email)
                ->setBody(
                    $this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
                        'Emails/registration.html.twig',
                        array('user'=>$user)

                    ),
                    'text/html'
                )
                /*
                 * If you also want to include a plaintext version of the message
                ->addPart(
                    $this->renderView(
                        'Emails/registration.txt.twig',
                        array('name' => $name)
                    ),
                    'text/plain'
                )
                */
            ;
            $this->get('mailer')->send($message);

            return new RedirectResponse(
                $this->generateUrl('registration_complete_route'));
        }
        return $this->render(
            'PublicBundle:Registration:register.html.twig',
            array('form'=>$form->createView())
        );
    }

    /**
     * @Route("/registration-complete", name="registration_complete_route")
     */
    public function registrationCompleteAction(){
        return $this->render(
            'PublicBundle:Registration:activation.html.twig'
        );
    }

    /**
     * @Route("/activation/{user_id}/{key}", name="activation_route")
     */
    public function activationAction($key, $user_id){
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('PublicBundle:User')->find($user_id);
        // Retrieving activation from db
        $activation = $user->getActivation();

        if($key == $activation){
            $user->setIsActive(1);
            $em->persist($user);
            $em->flush();

        }
        return $this->render(
            'PublicBundle:Registration:registration_complete.html.twig', array('user'=>$user)
        );
    }
}