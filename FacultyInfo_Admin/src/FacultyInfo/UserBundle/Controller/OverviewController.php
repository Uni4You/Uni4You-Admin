<?php

namespace FacultyInfo\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OverviewController extends Controller {

	public function indexAction() {
		$users = $this -> container -> get('doctrine') -> getManager() -> getRepository('FacultyInfoUserBundle:User') -> findAll();

		return $this -> render('FacultyInfoUserBundle:Overview:index.html.twig', array('users' => $users));
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

		$this -> get('session') -> getFlashBag() -> add('success', $this -> get('translator') -> trans('userManagement.delete.userDeleted'));
		return $this -> redirect($this -> generateUrl('facultyinfo_user_overview'));
	}

}
