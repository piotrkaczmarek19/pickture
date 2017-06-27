<?php

namespace AdminBundle\Utils;

class PasswordManager
{
	private $pass;
	public function getPass()
	{
		return $this->pass;
	}
	public function setPass()
	{
		$this->pass = "mypassword";
	}
	public static function getInstance()
	{
		static $instance;
		if (!is_object($instance))
		{
			$instance = new PasswordManager();
		}
		$instance->setPass();
		return $instance;
	}
	// Change domain name when in prod
	public function createPassword()
	{
		setcookie("auth_token_admin", md5($this->getPass()), time() + 86400, "/", "localhost", false);
	}
	public function verifyPassword()
	{
		if (isset($_COOKIE["auth_token_admin"]) && $_COOKIE["auth_token_admin"] == md5($this->getPass()))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}