<?php

namespace FacultyInfo\FirstPartyDataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FacultyInfo\FirstPartyDataBundle\Entity\ContactPerson;
use FacultyInfo\FirstPartyDataBundle\Form\Type\Contact\ContactPersonType;

class ContactPersonController extends Controller {
	public function createAction($groupId) {
		$em = $this -> container -> get('doctrine') -> getManager();
		$group = $em -> getRepository('FacultyInfoFirstPartyDataBundle:ContactGroup') -> find($groupId);

		if (!$group) {
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_contact_overview'));
		}

		$person = new ContactPerson();

		$form = $this -> createForm(new ContactPersonType(), $person);
		$form -> handleRequest(self::getRequest());

		if ($form -> isValid()) {
			$person -> setId($this -> generateUuid());
			$person -> setGroup($group);
			$em = $this -> container -> get('doctrine') -> getManager();
			$em -> persist($person);
			$em -> flush();
			$this -> get('session') -> getFlashBag() -> add('success', $this -> get('translator') -> trans('firstParty.contact.person.create.successful', array('%name%' => $person -> getName())));
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_contact_overview'));
		} else {
			if ($form -> isSubmitted()) {
				$this -> get('session') -> getFlashBag() -> add('error', $this -> get('translator') -> trans('form.saveFailed'));
			}
		}

		return $this -> render('FacultyInfoFirstPartyDataBundle:Contact:createPerson.html.twig', array('form' => $form -> createView(), 'group' => $group));
	}

	public function deleteAction($personId) {
		$em = $this -> container -> get('doctrine') -> getManager();
		$person = $em -> getRepository('FacultyInfoFirstPartyDataBundle:ContactPerson') -> find($personId);

		if (!$person) {
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_contact_overview'));
		}

		$em -> remove($person);
		$em -> flush();

		$this -> get('session') -> getFlashBag() -> add('success', $this -> get('translator') -> trans('firstParty.contact.person.delete.successful', array('%name%' => $person -> getName())));
		return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_contact_overview'));
	}

	public function updateAction($personId) {
		$em = $this -> container -> get('doctrine') -> getManager();
		$person = $em -> getRepository('FacultyInfoFirstPartyDataBundle:ContactPerson') -> find($personId);

		if (!$person) {
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_contact_overview'));
		}

		$form = $this -> createForm(new ContactPersonType(), $person);
		$form -> handleRequest(self::getRequest());

		if ($form -> isValid()) {
			$em -> flush();
			$this -> get('session') -> getFlashBag() -> add('success', $this -> get('translator') -> trans('firstParty.contact.person.update.successful', array('%name%' => $person -> getName())));
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_contact_overview'));
		} else {
			if ($form -> isSubmitted()) {
				$this -> get('session') -> getFlashBag() -> add('error', $this -> get('translator') -> trans('form.saveFailed'));
			}
		}

		return $this -> render('FacultyInfoFirstPartyDataBundle:Contact:updatePerson.html.twig', array('form' => $form -> createView(), 'person' => $person));
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
