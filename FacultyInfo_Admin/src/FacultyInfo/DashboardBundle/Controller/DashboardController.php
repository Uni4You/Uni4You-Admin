<?php

namespace FacultyInfo\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller {
	public function indexAction() {
		$em = $this -> container -> get('doctrine') -> getManager();

		$thirdPartyMeta = $em -> getRepository('FacultyInfoThirdPartyDataBundle:Metadata') -> findBy(array('isThirdPartyData' => TRUE));
		$status = true;
		foreach ($thirdPartyMeta as $module) {
			$status = $status && ($module -> getLastStatuscode() === 0);
		}

		$thirdPartyLastUpdateRecord = $em -> getRepository('FacultyInfoThirdPartyDataBundle:Metadata') -> findBy(array('isThirdPartyData' => TRUE), array('lastUpdate' => 'desc'), 1);
		$thirdPartyLastUpdate = null;
		foreach ($thirdPartyLastUpdateRecord as $module) {
			$thirdPartyLastUpdate = $module -> getLastUpdate();
			break;
		}

		$firstPartyLastUpdateRecord = $em -> getRepository('FacultyInfoThirdPartyDataBundle:Metadata') -> findBy(array('isThirdPartyData' => FALSE), array('lastUpdate' => 'desc'), 1);
		$firstPartyLastUpdate = null;
		foreach ($firstPartyLastUpdateRecord as $module) {
			$firstPartyLastUpdate = $module -> getLastUpdate();
			break;
		}

		return $this -> render('FacultyInfoDashboardBundle:Dashboard:index.html.twig', array('thirdPartyStatus' => $status, 'firstPartyLastUpdate' => $firstPartyLastUpdate, 'thirdPartyLastUpdate' => $thirdPartyLastUpdate));
	}

}
