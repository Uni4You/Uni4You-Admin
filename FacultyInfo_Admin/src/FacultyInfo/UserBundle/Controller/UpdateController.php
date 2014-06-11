<?php

namespace FacultyInfo\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FacultyInfo\UserBundle\Form\Type\UpdateUserType;
use FacultyInfo\UserBundle\Form\Type\PasswordType;
use FacultyInfo\UserBundle\Entity\Password;

class UpdateController extends Controller {

	public function indexAction($userId) {
		$em = $this -> container -> get('doctrine') -> getManager();
		$user = $em -> getRepository('FacultyInfoUserBundle:User') -> find($userId);

		$userForm = $this -> createForm(new UpdateUserType(), $user);
		$userForm -> handleRequest(self::getRequest());

		if ($userForm -> isSubmitted()) {
			if ($userForm -> isValid()) {
				$em -> flush();
				$this -> get('session') -> getFlashBag() -> add('success', $this -> get('translator') -> trans('userManagement.update.userSuccessful', array('%name%' => $user -> getName())));
				return $this -> redirect($this -> generateUrl('facultyinfo_user_overview'));
			} else {
				$this -> get('session') -> getFlashBag() -> add('error', $this -> get('translator') -> trans('form.saveFailed'));
			}
		}

		$currentUser = $this -> get('security.context') -> getToken() -> getUser();
		if ($currentUser -> getId() === $userId) {
			$pwd = new Password();

			$pwdForm = $this -> createForm(new PasswordType(), $pwd);
			$pwdForm -> handleRequest(self::getRequest());

			if ($pwdForm -> isSubmitted()) {
				if ($pwdForm -> isValid()) {
					$encoder = $this -> container -> get('facultyinfo_user_custom_encoder');
					$encodedPwd = $encoder -> encodePassword($pwd -> getFirst(), $currentUser -> getSalt());
					$user -> setPassword($encodedPwd);
					$em -> flush();
					$this -> get('session') -> getFlashBag() -> add('success', $this -> get('translator') -> trans('userManagement.update.passwordSuccessful', array('%name%' => $user -> getName())));
					return $this -> redirect($this -> generateUrl('facultyinfo_user_overview'));
				} else {
					$pwdForm = $this -> createForm(new PasswordType(), new Password());
					$this -> get('session') -> getFlashBag() -> add('error', $this -> get('translator') -> trans('form.saveFailed'));
				}
			}
		} else {
			$pwdForm = null;
		}
		return $this -> render('FacultyInfoUserBundle:Update:index.html.twig', array('user' => $user, 'userForm' => $userForm -> createView(), 'pwdForm' => $pwdForm != null ? $pwdForm -> createView() : null));
	}

}
