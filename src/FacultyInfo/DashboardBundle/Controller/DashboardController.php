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

		$records = $em -> getRepository('FacultyInfoFirstPartyDataBundle:Businesshours') -> findBy(array(), array('timestamp' => 'desc'), 1);
		foreach ($records as $record) {
			$firstPartyLastUpdate = $record -> getTimestamp();
			break;
		}
		$records = $em -> getRepository('FacultyInfoFirstPartyDataBundle:BusinesshoursFacility') -> findBy(array(), array('timestamp' => 'desc'), 1);
		foreach ($records as $record) {
			$firstPartyLastUpdate = $record -> getTimestamp() > $firstPartyLastUpdate ? $record -> getTimestamp() : $firstPartyLastUpdate;
			break;
		}
		$records = $em -> getRepository('FacultyInfoFirstPartyDataBundle:ContactPerson') -> findBy(array(), array('timestamp' => 'desc'), 1);
		foreach ($records as $record) {
			$firstPartyLastUpdate = $record -> getTimestamp() > $firstPartyLastUpdate ? $record -> getTimestamp() : $firstPartyLastUpdate;
			break;
		}
		$records = $em -> getRepository('FacultyInfoFirstPartyDataBundle:ContactGroup') -> findBy(array(), array('timestamp' => 'desc'), 1);
		foreach ($records as $record) {
			$firstPartyLastUpdate = $record -> getTimestamp() > $firstPartyLastUpdate ? $record -> getTimestamp() : $firstPartyLastUpdate;
			break;
		}
		$records = $em -> getRepository('FacultyInfoFirstPartyDataBundle:Mapmarker') -> findBy(array(), array('timestamp' => 'desc'), 1);
		foreach ($records as $record) {
			$firstPartyLastUpdate = $record -> getTimestamp() > $firstPartyLastUpdate ? $record -> getTimestamp() : $firstPartyLastUpdate;
			break;
		}
		$records = $em -> getRepository('FacultyInfoFirstPartyDataBundle:MapmarkerCategory') -> findBy(array(), array('timestamp' => 'desc'), 1);
		foreach ($records as $record) {
			$firstPartyLastUpdate = $record -> getTimestamp() > $firstPartyLastUpdate ? $record -> getTimestamp() : $firstPartyLastUpdate;
			break;
		}

		return $this -> render('FacultyInfoDashboardBundle:Dashboard:index.html.twig', array('thirdPartyStatus' => $status, 'firstPartyLastUpdate' => $firstPartyLastUpdate, 'thirdPartyLastUpdate' => $thirdPartyLastUpdate));
	}

}
