<?php

namespace FacultyInfo\FirstPartyDataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FacultyInfo\ThirdPartyDataBundle\Entity\Metadata;

class OverviewController extends Controller {
	public function indexAction() {
		$modules = $this -> container -> get('doctrine') -> getManager() -> getRepository('FacultyInfoThirdPartyDataBundle:Metadata') -> findBy(array('isThirdPartyData' => FALSE), array('name' => 'asc'));

		foreach ($modules as $module) {
			if ($module -> getName() == Metadata::NAME_MAPMARKER)
				$mapmarker = $module;
			elseif ($module -> getName() == Metadata::NAME_BUSINESSHOURS)
				$businesshours = $module;
			elseif ($module -> getName() == Metadata::NAME_CONTACTPERSON)
				$contactperson = $module;
		}

		$mapmarker = isset($mapmarker) ? $mapmarker : null;
		$businesshours = isset($businesshours) ? $businesshours : null;
		$contactperson = isset($contactperson) ? $contactperson : null;

		return $this -> render('FacultyInfoFirstPartyDataBundle:Overview:index.html.twig', array('mapmarker' => $mapmarker, 'businesshours' => $businesshours, 'contactperson' => $contactperson));
	}

}
