<?php

namespace FacultyInfo\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OverviewController extends Controller {

	public function indexAction() {
		$users = $this -> container -> get('doctrine') -> getManager() -> getRepository('FacultyInfoUserBundle:User') -> findBy(array(), array('name' => 'asc'));

		$currentUser = $this -> get('security.context') -> getToken() -> getUser();
		foreach ($users as $key => $user) {
			if ($user -> getId() === $currentUser -> getId()) {
				$me = $user;
				unset($users[$key]);
				break;
			}
		}

		return $this -> render('FacultyInfoUserBundle:Overview:index.html.twig', array('users' => $users, 'me' => $me));
	}

	public function deleteAction($userId) {
		$em = $this -> container -> get('doctrine') -> getManager();
		$user = $em -> getRepository('FacultyInfoUserBundle:User') -> find($userId);

		if (!$user) {
			$this -> get('session') -> getFlashBag() -> add('error', $this -> get('translator') -> trans('userManagement.error.invalidUserId'));
			return $this -> redirect($this -> generateUrl('facultyinfo_user_overview'));
		}

		$em -> remove($user);
		$em -> flush();

		$this -> get('session') -> getFlashBag() -> add('success', $this -> get('translator') -> trans('userManagement.delete.successful', array('%name%' => $user -> getName())));
		return $this -> redirect($this -> generateUrl('facultyinfo_user_overview'));
	}

	public function resetAction($userId) {
		$em = $this -> container -> get('doctrine') -> getManager();
		$user = $em -> getRepository('FacultyInfoUserBundle:User') -> find($userId);

		if (!$user) {
			$this -> get('session') -> getFlashBag() -> add('error', $this -> get('translator') -> trans('userManagement.error.invalidUserId'));
			return $this -> redirect($this -> generateUrl('facultyinfo_user_overview'));
		}

		$pwd = $this -> generatePassword();
		$currentUser = $this -> get('security.context') -> getToken() -> getUser();
		$encoder = $this -> container -> get('facultyinfo_user_custom_encoder');
		$encodedPwd = $encoder -> encodePassword($pwd, $currentUser -> getSalt());
		$user -> setPassword($encodedPwd);

		$em -> flush();

		$this -> get('session') -> getFlashBag() -> add('success', $this -> get('translator') -> trans('userManagement.passwordReset.successful', array('%name%' => $user -> getName(), '%pwd%' => $pwd)));
		return $this -> redirect($this -> generateUrl('facultyinfo_user_overview'));
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

}
