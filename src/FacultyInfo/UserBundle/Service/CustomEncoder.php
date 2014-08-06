<?php
namespace FacultyInfo\UserBundle\Service;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class CustomEncoder implements PasswordEncoderInterface
{

	public function encodePassword ($raw, $salt)
	{
		return sha1($salt . $raw);
	}

	public function isPasswordValid ($encoded, $raw, $salt)
	{
		return $encoded === $this->encodePassword($raw, $salt);
	}
}