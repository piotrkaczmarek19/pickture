<?php

namespace AdminBundle\EventListener;

use PublicBundle\Entity\User;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use AdminBundle\Utils\PasswordManager;

class AddToken
{
	/** @var \Symfony\Component\Security\Http\Authentication\AuthenticationUtils */
	private $authChecker;

	/** @var \Doctrine\ORM\EntityManager */
	private $em;

	/**
	 * Constructor
	 * 
	 * @param authChecker $authChecker
	 * @param Doctrine        $doctrine
	 */
	public function __construct(AuthorizationChecker $authChecker, Doctrine $doctrine)
	{
		$this->authChecker = $authChecker;
		$this->em = $doctrine->getEntityManager();
	}

	/**
	 * 
	 * @param InteractiveLoginEvent $event
	 */	
	public function onSecurityInteractivelogin(InteractiveLoginEvent $event)
	{
		if ($this->authChecker->isGranted('IS_AUTHENTICATED_FULLY'))
		{
			$pwManager = PasswordManager::getInstance();
			$pwManager->createPassword();
			//setcookie("auth_token", "teston auth", time() + 86400, "/", "localhost");		
		}
	}
}