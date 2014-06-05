<?php

namespace FacultyInfo\ThirdPartyDataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OverviewController extends Controller {
	public function indexAction($eventId) {
		
		
		$event = $this -> getDoctrine() -> getRepository('FacultyInfoThirdPartyDataBundle:Event') -> find($eventId);
		
		var_dump($event);
		
		exit();

		// if (!$product) {
			// throw $this -> createNotFoundException('No product found for id ' . $id);
		// }
// 
		// return $this -> render('FacultyInfoThirdPartyDataBundle:Default:index.html.twig');
	}

}
