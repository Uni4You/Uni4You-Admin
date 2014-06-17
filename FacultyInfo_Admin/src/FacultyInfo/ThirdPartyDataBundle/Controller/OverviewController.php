<?php

namespace FacultyInfo\ThirdPartyDataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FacultyInfo\ThirdPartyDataBundle\Entity\Metadata;

class OverviewController extends Controller {
	public function indexAction() {

		$modules = $this -> container -> get('doctrine') -> getManager() -> getRepository('FacultyInfoThirdPartyDataBundle:Metadata') -> findBy(array('isThirdPartyData' => TRUE), array('name' => 'asc'));

		foreach ($modules as $module) {
			if ($module -> getName() == Metadata::NAME_BUSLINE)
				$busline = $module;
			elseif ($module -> getName() == Metadata::NAME_EVENT)
				$event = $module;
			elseif ($module -> getName() == Metadata::NAME_FAQ)
				$faq = $module;
			elseif ($module -> getName() == Metadata::NAME_MENU)
				$menu = $module;
			elseif ($module -> getName() == Metadata::NAME_NEWS)
				$news = $module;
			elseif ($module -> getName() == Metadata::NAME_SPORTSCOURSE)
				$sportscourse = $module;
		}

		return $this -> render('FacultyInfoThirdPartyDataBundle:Overview:index.html.twig', array('busline' => isset($busline) ? $busline : null, 'event' => isset($event) ? $event : null, 'faq' => isset($faq) ? $faq : null, 'menu' => isset($menu) ? $menu : null, 'news' => isset($menu) ? $menu : null, 'news' => isset($news) ? $news : null, 'sportscourse' => isset($sportscourse) ? $sportscourse : null));
	}

}
