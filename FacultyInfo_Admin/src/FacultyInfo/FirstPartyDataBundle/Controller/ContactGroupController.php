<?php

namespace FacultyInfo\FirstPartyDataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FacultyInfo\FirstPartyDataBundle\Entity\ContactGroup;
use FacultyInfo\FirstPartyDataBundle\Form\Type\Contact\ContactGroupType;

class ContactGroupController extends Controller {
	public function overviewAction() {
		$groups = $this -> container -> get('doctrine') -> getManager() -> getRepository('FacultyInfoFirstPartyDataBundle:ContactGroup') -> findBy(array(), array('title' => 'asc'));

		return $this -> render('FacultyInfoFirstPartyDataBundle:Contact:overview.html.twig', array('groups' => $groups));
	}

	public function createAction() {
		$group = new ContactGroup();

		$form = $this -> createForm(new ContactGroupType(), $group);
		$form -> handleRequest(self::getRequest());

		if ($form -> isValid()) {
			$group -> setId($this -> generateUuid());
			$em = $this -> container -> get('doctrine') -> getManager();
			$em -> persist($group);
			$em -> flush();
			$this -> get('session') -> getFlashBag() -> add('success', $this -> get('translator') -> trans('firstParty.contact.group.create.successful', array('%title%' => $group -> getTitle())));
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_contact_overview'));
		} else {
			if ($form -> isSubmitted()) {
				$this -> get('session') -> getFlashBag() -> add('error', $this -> get('translator') -> trans('form.saveFailed'));
			}
		}

		return $this -> render('FacultyInfoFirstPartyDataBundle:Contact:createGroup.html.twig', array('form' => $form -> createView()));
	}

	public function deleteAction($groupId) {
		$em = $this -> container -> get('doctrine') -> getManager();
		$group = $em -> getRepository('FacultyInfoFirstPartyDataBundle:ContactGroup') -> find($groupId);

		if (!$group) {
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_contact_overview'));
		}

		$em -> remove($group);
		$em -> flush();

		$this -> get('session') -> getFlashBag() -> add('success', $this -> get('translator') -> trans('firstParty.contact.group.delete.successful', array('%title%' => $group -> getTitle())));
		return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_contact_overview'));
	}

	public function updateAction($groupId) {
		$em = $this -> container -> get('doctrine') -> getManager();
		$group = $em -> getRepository('FacultyInfoFirstPartyDataBundle:ContactGroup') -> find($groupId);

		if (!$group) {
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_contact_overview'));
		}

		$form = $this -> createForm(new ContactGroupType(), $group);
		$form -> handleRequest(self::getRequest());

		if ($form -> isValid()) {
			$em -> flush();
			$this -> get('session') -> getFlashBag() -> add('success', $this -> get('translator') -> trans('firstParty.contact.group.update.successful', array('%title%' => $group -> getTitle())));
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_contact_overview'));
		} else {
			if ($form -> isSubmitted()) {
				$this -> get('session') -> getFlashBag() -> add('error', $this -> get('translator') -> trans('form.saveFailed'));
			}
		}

		return $this -> render('FacultyInfoFirstPartyDataBundle:Contact:updateGroup.html.twig', array('form' => $form -> createView(), 'group' => $group));
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
