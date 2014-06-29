<?php

namespace FacultyInfo\FirstPartyDataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FacultyInfo\FirstPartyDataBundle\Entity\MapmarkerCategory;
use FacultyInfo\FirstPartyDataBundle\Entity\Mapmarker;
use FacultyInfo\FirstPartyDataBundle\Form\Type\Mapmarker\EntryType;

class MapmarkerEntryController extends Controller {
	public function updateAction($entryId) {
		$em = $this -> container -> get('doctrine') -> getManager();
		$entry = $em -> getRepository('FacultyInfoFirstPartyDataBundle:Mapmarker') -> find($entryId);

		if (!$entry) {
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_mapmarker_overview'));
		}

		$form = $this -> createForm(new EntryType(), $entry);
		$form -> handleRequest(self::getRequest());

		if ($form -> isValid()) {
			$em -> flush();
			$this -> get('session') -> getFlashBag() -> add('success', $this -> get('translator') -> trans('firstParty.mapmarker.entry.update.successful', array('%name%' => $entry -> getName())));
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_mapmarker_category', array('categoryId' => $entry -> getCategory() -> getId())));
		} else {
			if ($form -> isSubmitted()) {
				$this -> get('session') -> getFlashBag() -> add('error', $this -> get('translator') -> trans('form.saveFailed'));
			}
		}

		return $this -> render('FacultyInfoFirstPartyDataBundle:Mapmarker:updateEntry.html.twig', array('form' => $form -> createView(), 'entry' => $entry));
	}

	public function createAction($categoryId) {
		$em = $this -> container -> get('doctrine') -> getManager();
		$category = $em -> getRepository('FacultyInfoFirstPartyDataBundle:MapmarkerCategory') -> find($categoryId);

		if (!$category) {
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_mapmarker_overview'));
		}

		$entry = new Mapmarker();

		$form = $this -> createForm(new EntryType(), $entry);
		$form -> handleRequest(self::getRequest());

		if ($form -> isValid()) {
			$entry -> setId($this -> generateUuid());
			$entry -> setCategory($category);
			$em = $this -> container -> get('doctrine') -> getManager();
			$em -> persist($entry);
			$em -> flush();
			$this -> get('session') -> getFlashBag() -> add('success', $this -> get('translator') -> trans('firstParty.mapmarker.entry.create.successful', array('%name%' => $entry -> getName())));
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_mapmarker_category', array('categoryId' => $category -> getId())));
		} else {
			if ($form -> isSubmitted()) {
				$this -> get('session') -> getFlashBag() -> add('error', $this -> get('translator') -> trans('form.saveFailed'));
			}
		}

		return $this -> render('FacultyInfoFirstPartyDataBundle:Mapmarker:createEntry.html.twig', array('form' => $form -> createView(), 'category' => $category));
	}

	public function deleteAction($entryId, $confirmed) {
		$em = $this -> container -> get('doctrine') -> getManager();
		$entry = $em -> getRepository('FacultyInfoFirstPartyDataBundle:Mapmarker') -> find($entryId);

		if (!$entry) {
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_mapmarker_overview'));
		}

		if ($confirmed === "1") {
			$em -> remove($entry);
			$em -> flush();

			$this -> get('session') -> getFlashBag() -> add('success', $this -> get('translator') -> trans('firstParty.mapmarker.entry.delete.successful', array('%name%' => $entry -> getName())));
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_mapmarker_category', array('categoryId' => $entry -> getCategory() -> getId())));
		}

		$confirmUrl = $this -> generateUrl('facultyinfo_firstparty_mapmarker_entry_delete', array('entryId' => $entryId, 'confirmed' => 1));
		$cancelUrl = $this -> generateUrl('facultyinfo_firstparty_mapmarker_overview');
		return $this -> render('FacultyInfoFirstPartyDataBundle:Overview:delete.html.twig', array('name' => $entry -> getName(), 'text' => 'firstParty.mapmarker.entry.delete.text', 'confirmUrl' => $confirmUrl, 'cancelUrl' => $cancelUrl));
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
