<?php

namespace FacultyInfo\ThirdPartyDataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FacultyInfo\ThirdPartyDataBundle\Entity\Metadata;
use FacultyInfo\ThirdPartyDataBundle\Form\Type\UpdateSourceUrlType;

class UpdateController extends Controller {
	public function indexAction($id) {

		$em = $this -> container -> get('doctrine') -> getManager();
		$metadata = $em -> getRepository('FacultyInfoThirdPartyDataBundle:Metadata') -> find($id);

		$form = $this -> createForm(new UpdateSourceUrlType(), $metadata);
		$form -> handleRequest(self::getRequest());

		if ($form -> isValid()) {
			$em -> flush();
			$this -> get('session') -> getFlashBag() -> add('success', $this -> get('translator') -> trans('thirdParty.update.successful', array('%name%' => $this -> get('translator') -> trans('thirdParty.' . $metadata -> getName() . '.name'))));
			return $this -> redirect($this -> generateUrl('facultyinfo_thirdparty_overview'));
		} else {
			if ($form -> isSubmitted()) {
				$this -> get('session') -> getFlashBag() -> add('error', $this -> get('translator') -> trans('form.saveFailed'));
			}
		}

		return $this -> render('FacultyInfoThirdPartyDataBundle:Update:index.html.twig', array('form' => $form -> createView(), 'module' => $metadata));
	}

}
