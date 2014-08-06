<?php

namespace FacultyInfo\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FacultyInfo\UserBundle\Form\Type\CreateUserType;
use FacultyInfo\UserBundle\Entity\User;

class CreateController extends Controller {

	public function indexAction() {
		$user = new User();

		$form = $this -> createForm(new CreateUserType(), $user);
		$form -> handleRequest(self::getRequest());

		if ($form -> isValid()) {
			$pwd = $this -> generatePassword();
			$currentUser = $this -> get('security.context') -> getToken() -> getUser();
			$encoder = $this -> container -> get('facultyinfo_user_custom_encoder');
			$encodedPwd = $encoder -> encodePassword($pwd, $currentUser -> getSalt());
			$user -> setPassword($encodedPwd);
			$user -> setId($this -> generateUuid());
			$em = $this -> container -> get('doctrine') -> getManager();
			$em -> persist($user);
			$em -> flush();
			$this -> get('session') -> getFlashBag() -> add('success', $this -> get('translator') -> trans('userManagement.create.successful', array('%name%' => $user -> getName(), '%pwd%' => $pwd)));
			return $this -> redirect($this -> generateUrl('facultyinfo_user_overview'));
		} else {
			if ($form -> isSubmitted()) {
				$this -> get('session') -> getFlashBag() -> add('error', $this -> get('translator') -> trans('form.saveFailed'));
			}
		}

		return $this -> render('FacultyInfoUserBundle:Create:index.html.twig', array('form' => $form -> createView()));
	}

	private function generatePassword() {
		$length = 10;
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}

	private function generateUuid() {
		return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
		// 32 bits for "time_low"
		mt_rand(0, 0xffff), mt_rand(0, 0xffff),

		// 16 bits for "time_mid"
		mt_rand(0, 0xffff),

		// 16 bits for "time_hi_and_version",
		// four most significant bits holds version number 4
		mt_rand(0, 0x0fff) | 0x4000,

		// 16 bits, 8 bits for "clk_seq_hi_res",
		// 8 bits for "clk_seq_low",
		// two most significant bits holds zero and one for variant DCE1.1
		mt_rand(0, 0x3fff) | 0x8000,

		// 48 bits for "node"
		mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
	}

}
