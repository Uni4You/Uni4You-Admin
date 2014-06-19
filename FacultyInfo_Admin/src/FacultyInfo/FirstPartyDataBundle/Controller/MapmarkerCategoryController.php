<?php

namespace FacultyInfo\FirstPartyDataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FacultyInfo\FirstPartyDataBundle\Entity\MapmarkerCategory;
use FacultyInfo\FirstPartyDataBundle\Form\Type\Mapmarker\CategoryType;

class MapmarkerCategoryController extends Controller {
	public function overviewAction() {
		$categories = $this -> container -> get('doctrine') -> getManager() -> getRepository('FacultyInfoFirstPartyDataBundle:MapmarkerCategory') -> findBy(array('superCategory' => null), array('title' => 'asc'));

		return $this -> render('FacultyInfoFirstPartyDataBundle:Mapmarker:overview.html.twig', array('categories' => $categories));
	}

	public function detailsAction($categoryId) {
		$category = $this -> container -> get('doctrine') -> getManager() -> getRepository('FacultyInfoFirstPartyDataBundle:MapmarkerCategory') -> find($categoryId);

		return $this -> render('FacultyInfoFirstPartyDataBundle:Mapmarker:category.html.twig', array('category' => $category));
	}

	public function createSuperAction() {
		$category = new MapmarkerCategory();

		$form = $this -> createForm(new CategoryType(), $category);
		$form -> handleRequest(self::getRequest());

		if ($form -> isValid()) {
			$category -> setId($this -> generateUuid());
			$em = $this -> container -> get('doctrine') -> getManager();
			$em -> persist($category);
			$em -> flush();
			$this -> get('session') -> getFlashBag() -> add('success', $this -> get('translator') -> trans('firstParty.mapmarker.category.create.successful', array('%title%' => $category -> getTitle())));
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_mapmarker_overview'));
		} else {
			if ($form -> isSubmitted()) {
				$this -> get('session') -> getFlashBag() -> add('error', $this -> get('translator') -> trans('form.saveFailed'));
			}
		}

		return $this -> render('FacultyInfoFirstPartyDataBundle:Mapmarker:createSuperCategory.html.twig', array('form' => $form -> createView()));
	}

	public function createSubAction($superCategoryId) {
		$em = $this -> container -> get('doctrine') -> getManager();
		$superCategory = $em -> getRepository('FacultyInfoFirstPartyDataBundle:MapmarkerCategory') -> find($superCategoryId);
		if ($superCategory == null) {
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_mapmarker_overview'));
		}

		$category = new MapmarkerCategory();

		$form = $this -> createForm(new CategoryType(), $category);
		$form -> handleRequest(self::getRequest());

		if ($form -> isValid()) {
			$category -> setId($this -> generateUuid());
			$category -> setSuperCategory($superCategory);

			$em -> persist($category);
			$em -> flush();
			$this -> get('session') -> getFlashBag() -> add('success', $this -> get('translator') -> trans('firstParty.mapmarker.category.create.successful', array('%title%' => $category -> getTitle(), '%superCategoryTitle%' => $superCategory -> getTitle())));
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_mapmarker_overview'));
		} else {
			if ($form -> isSubmitted()) {
				$this -> get('session') -> getFlashBag() -> add('error', $this -> get('translator') -> trans('form.saveFailed'));
			}
		}

		return $this -> render('FacultyInfoFirstPartyDataBundle:Mapmarker:createSubCategory.html.twig', array('form' => $form -> createView(), 'superCategory' => $superCategory));
	}

	public function deleteAction($categoryId) {
		$em = $this -> container -> get('doctrine') -> getManager();
		$category = $em -> getRepository('FacultyInfoFirstPartyDataBundle:MapmarkerCategory') -> find($categoryId);

		if (!$category) {
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_mapmarker_overview'));
		}

		$em -> remove($category);
		$em -> flush();

		$this -> get('session') -> getFlashBag() -> add('success', $this -> get('translator') -> trans('firstParty.mapmarker.category.delete.successful', array('%title%' => $category -> getTitle())));
		return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_mapmarker_overview'));
	}

	public function updateAction($categoryId) {
		$em = $this -> container -> get('doctrine') -> getManager();
		$category = $em -> getRepository('FacultyInfoFirstPartyDataBundle:MapmarkerCategory') -> find($categoryId);

		if (!$category) {
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_mapmarker_overview'));
		}

		$form = $this -> createForm(new CategoryType(), $category);
		$form -> handleRequest(self::getRequest());

		if ($form -> isValid()) {
			$em -> flush();
			$this -> get('session') -> getFlashBag() -> add('success', $this -> get('translator') -> trans('firstParty.mapmarker.category.update.successful', array('%title%' => $category -> getTitle())));
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_mapmarker_overview'));
		} else {
			if ($form -> isSubmitted()) {
				$this -> get('session') -> getFlashBag() -> add('error', $this -> get('translator') -> trans('form.saveFailed'));
			}
		}

		return $this -> render('FacultyInfoFirstPartyDataBundle:Mapmarker:updateCategory.html.twig', array('form' => $form -> createView(), 'category' => $category));
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
