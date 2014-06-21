<?php

namespace FacultyInfo\FirstPartyDataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FacultyInfo\FirstPartyDataBundle\Entity\BusinesshoursFacility;
use FacultyInfo\FirstPartyDataBundle\Entity\Businesshours;
use FacultyInfo\FirstPartyDataBundle\Form\Type\Businesshours\BusinesshoursFacilityType;

class BusinesshoursController extends Controller {
	public function overviewAction() {
		$libraries = $this -> container -> get('doctrine') -> getManager() -> getRepository('FacultyInfoFirstPartyDataBundle:BusinesshoursFacility') -> findBy(array("type" => BusinesshoursFacility::TYPE_LIBRARY), array('name' => 'asc'));
		$cafeterias = $this -> container -> get('doctrine') -> getManager() -> getRepository('FacultyInfoFirstPartyDataBundle:BusinesshoursFacility') -> findBy(array("type" => BusinesshoursFacility::TYPE_CAFETERIA), array('name' => 'asc'));

		return $this -> render('FacultyInfoFirstPartyDataBundle:Businesshours:overview.html.twig', array('libraries' => $libraries, 'cafeterias' => $cafeterias));
	}

	public function createLibraryAction() {
		$library = new BusinesshoursFacility();
		$library -> setId($this -> generateUuid());
		$library -> setType(BusinesshoursFacility::TYPE_LIBRARY);
		$library -> setSemesterMonday($this -> constructBusinesshours($library, Businesshours::PHASE_SEMESTER, Businesshours::DAYOFWEEK_MONDAY));
		$library -> setSemesterTuesday($this -> constructBusinesshours($library, Businesshours::PHASE_SEMESTER, Businesshours::DAYOFWEEK_TUESDAY));
		$library -> setSemesterWednesday($this -> constructBusinesshours($library, Businesshours::PHASE_SEMESTER, Businesshours::DAYOFWEEK_WEDNESDAY));
		$library -> setSemesterThursday($this -> constructBusinesshours($library, Businesshours::PHASE_SEMESTER, Businesshours::DAYOFWEEK_THURSDAY));
		$library -> setSemesterFriday($this -> constructBusinesshours($library, Businesshours::PHASE_SEMESTER, Businesshours::DAYOFWEEK_FRIDAY));
		$library -> setSemesterSaturday($this -> constructBusinesshours($library, Businesshours::PHASE_SEMESTER, Businesshours::DAYOFWEEK_SATURDAY));
		$library -> setSemesterSunday($this -> constructBusinesshours($library, Businesshours::PHASE_SEMESTER, Businesshours::DAYOFWEEK_SUNDAY));

		$form = $this -> createForm(new BusinesshoursFacilityType(), $library);
		$form -> handleRequest(self::getRequest());

		if ($form -> isValid()) {
			$this -> mapFromForm($library);
			$em = $this -> container -> get('doctrine') -> getManager();
			$em -> persist($library);
			$em -> flush();
			$this -> get('session') -> getFlashBag() -> add('success', $this -> get('translator') -> trans('firstParty.businesshours.create.library.successful', array('%name%' => $library -> getName())));
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_businesshours_overview'));
		} else {
			if ($form -> isSubmitted()) {
				$this -> get('session') -> getFlashBag() -> add('error', $this -> get('translator') -> trans('form.saveFailed'));
			}
		}

		return $this -> render('FacultyInfoFirstPartyDataBundle:Businesshours:createLibrary.html.twig', array('form' => $form -> createView(), 'facility' => $library));
	}

	public function createCafeteriaAction() {
		$cafeteria = new BusinesshoursFacility();
		$cafeteria -> setId($this -> generateUuid());
		$cafeteria -> setType(BusinesshoursFacility::TYPE_CAFETERIA);
		$cafeteria -> setSemesterMonday($this -> constructBusinesshours($cafeteria, Businesshours::PHASE_SEMESTER, Businesshours::DAYOFWEEK_MONDAY));
		$cafeteria -> setSemesterTuesday($this -> constructBusinesshours($cafeteria, Businesshours::PHASE_SEMESTER, Businesshours::DAYOFWEEK_TUESDAY));
		$cafeteria -> setSemesterWednesday($this -> constructBusinesshours($cafeteria, Businesshours::PHASE_SEMESTER, Businesshours::DAYOFWEEK_WEDNESDAY));
		$cafeteria -> setSemesterThursday($this -> constructBusinesshours($cafeteria, Businesshours::PHASE_SEMESTER, Businesshours::DAYOFWEEK_THURSDAY));
		$cafeteria -> setSemesterFriday($this -> constructBusinesshours($cafeteria, Businesshours::PHASE_SEMESTER, Businesshours::DAYOFWEEK_FRIDAY));
		$cafeteria -> setSemesterSaturday($this -> constructBusinesshours($cafeteria, Businesshours::PHASE_SEMESTER, Businesshours::DAYOFWEEK_SATURDAY));
		$cafeteria -> setSemesterSunday($this -> constructBusinesshours($cafeteria, Businesshours::PHASE_SEMESTER, Businesshours::DAYOFWEEK_SUNDAY));
		$cafeteria -> setBreakMonday($this -> constructBusinesshours($cafeteria, Businesshours::PHASE_BREAK, Businesshours::DAYOFWEEK_MONDAY));
		$cafeteria -> setBreakTuesday($this -> constructBusinesshours($cafeteria, Businesshours::PHASE_BREAK, Businesshours::DAYOFWEEK_TUESDAY));
		$cafeteria -> setBreakWednesday($this -> constructBusinesshours($cafeteria, Businesshours::PHASE_BREAK, Businesshours::DAYOFWEEK_WEDNESDAY));
		$cafeteria -> setBreakThursday($this -> constructBusinesshours($cafeteria, Businesshours::PHASE_BREAK, Businesshours::DAYOFWEEK_THURSDAY));
		$cafeteria -> setBreakFriday($this -> constructBusinesshours($cafeteria, Businesshours::PHASE_BREAK, Businesshours::DAYOFWEEK_FRIDAY));
		$cafeteria -> setBreakSaturday($this -> constructBusinesshours($cafeteria, Businesshours::PHASE_BREAK, Businesshours::DAYOFWEEK_SATURDAY));
		$cafeteria -> setBreakSunday($this -> constructBusinesshours($cafeteria, Businesshours::PHASE_BREAK, Businesshours::DAYOFWEEK_SUNDAY));

		$form = $this -> createForm(new BusinesshoursFacilityType(), $cafeteria);
		$form -> handleRequest(self::getRequest());

		if ($form -> isValid()) {
			$this -> mapFromForm($cafeteria);
			$em = $this -> container -> get('doctrine') -> getManager();
			$em -> persist($cafeteria);
			$em -> flush();
			$this -> get('session') -> getFlashBag() -> add('success', $this -> get('translator') -> trans('firstParty.businesshours.create.cafeteria.successful', array('%name%' => $cafeteria -> getName())));
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_businesshours_overview'));
		} else {
			if ($form -> isSubmitted()) {
				$this -> get('session') -> getFlashBag() -> add('error', $this -> get('translator') -> trans('form.saveFailed'));
			}
		}

		return $this -> render('FacultyInfoFirstPartyDataBundle:Businesshours:createCafeteria.html.twig', array('form' => $form -> createView(), 'facility' => $cafeteria));
	}

	public function deleteAction($facilityId) {
		$em = $this -> container -> get('doctrine') -> getManager();
		$facility = $em -> getRepository('FacultyInfoFirstPartyDataBundle:BusinesshoursFacility') -> find($facilityId);

		if (!$facility) {
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_businesshours_overview'));
		}

		$em -> remove($facility);
		$em -> flush();

		$this -> get('session') -> getFlashBag() -> add('success', $this -> get('translator') -> trans('firstParty.businesshours.delete.successful', array('%name%' => $facility -> getName())));
		return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_businesshours_overview'));
	}

	public function updateAction($facilityId) {
		$em = $this -> container -> get('doctrine') -> getManager();
		$facility = $em -> getRepository('FacultyInfoFirstPartyDataBundle:BusinesshoursFacility') -> find($facilityId);

		if (!$facility) {
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_businesshours_overview'));
		}

		$this -> mapToForm($facility);

		$form = $this -> createForm(new BusinesshoursFacilityType(), $facility);
		$form -> handleRequest(self::getRequest());

		if ($form -> isValid()) {
			$this -> mapFromForm($facility);
			$em -> flush();
			$this -> get('session') -> getFlashBag() -> add('success', $this -> get('translator') -> trans('firstParty.businesshours.update.successful', array('%name%' => $facility -> getName())));
			return $this -> redirect($this -> generateUrl('facultyinfo_firstparty_businesshours_overview'));
		} else {
			if ($form -> isSubmitted()) {
				$this -> get('session') -> getFlashBag() -> add('error', $this -> get('translator') -> trans('form.saveFailed'));
			}
		}

		return $this -> render('FacultyInfoFirstPartyDataBundle:Businesshours:update.html.twig', array('form' => $form -> createView(), 'facility' => $facility));
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

	private function mapToForm($facility) {
		foreach ($facility->getBusinesshours() as $businesshours) {
			if ($businesshours -> getPhase() === Businesshours::PHASE_SEMESTER) {
				if ($businesshours -> getDayofweek() === Businesshours::DAYOFWEEK_MONDAY)
					$facility -> setSemesterMonday($businesshours);
				elseif ($businesshours -> getDayofweek() === Businesshours::DAYOFWEEK_TUESDAY)
					$facility -> setSemesterTuesday($businesshours);
				elseif ($businesshours -> getDayofweek() === Businesshours::DAYOFWEEK_WEDNESDAY)
					$facility -> setSemesterWednesday($businesshours);
				elseif ($businesshours -> getDayofweek() === Businesshours::DAYOFWEEK_THURSDAY)
					$facility -> setSemesterThursday($businesshours);
				elseif ($businesshours -> getDayofweek() === Businesshours::DAYOFWEEK_FRIDAY)
					$facility -> setSemesterFriday($businesshours);
				elseif ($businesshours -> getDayofweek() === Businesshours::DAYOFWEEK_SATURDAY)
					$facility -> setSemesterSaturday($businesshours);
				elseif ($businesshours -> getDayofweek() === Businesshours::DAYOFWEEK_SUNDAY)
					$facility -> setSemesterSunday($businesshours);
			} elseif ($businesshours -> getPhase() === Businesshours::PHASE_BREAK) {
				if ($businesshours -> getDayofweek() === Businesshours::DAYOFWEEK_MONDAY)
					$facility -> setBreakMonday($businesshours);
				elseif ($businesshours -> getDayofweek() === Businesshours::DAYOFWEEK_TUESDAY)
					$facility -> setBreakTuesday($businesshours);
				elseif ($businesshours -> getDayofweek() === Businesshours::DAYOFWEEK_WEDNESDAY)
					$facility -> setBreakWednesday($businesshours);
				elseif ($businesshours -> getDayofweek() === Businesshours::DAYOFWEEK_THURSDAY)
					$facility -> setBreakThursday($businesshours);
				elseif ($businesshours -> getDayofweek() === Businesshours::DAYOFWEEK_FRIDAY)
					$facility -> setBreakFriday($businesshours);
				elseif ($businesshours -> getDayofweek() === Businesshours::DAYOFWEEK_SATURDAY)
					$facility -> setBreakSaturday($businesshours);
				elseif ($businesshours -> getDayofweek() === Businesshours::DAYOFWEEK_SUNDAY)
					$facility -> setBreakSunday($businesshours);
			}
		}
	}

	private function mapFromForm($facility) {
		if ($facility -> getSemesterMonday() != null)
			$facility -> addBusinesshour($facility -> getSemesterMonday());
		if ($facility -> getSemesterTuesday() != null)
			$facility -> addBusinesshour($facility -> getSemesterTuesday());
		if ($facility -> getSemesterWednesday() != null)
			$facility -> addBusinesshour($facility -> getSemesterWednesday());
		if ($facility -> getSemesterThursday() != null)
			$facility -> addBusinesshour($facility -> getSemesterThursday());
		if ($facility -> getSemesterFriday() != null)
			$facility -> addBusinesshour($facility -> getSemesterFriday());
		if ($facility -> getSemesterSaturday() != null)
			$facility -> addBusinesshour($facility -> getSemesterSaturday());
		if ($facility -> getSemesterSunday() != null)
			$facility -> addBusinesshour($facility -> getSemesterSunday());
		if ($facility -> getBreakMonday() != null)
			$facility -> addBusinesshour($facility -> getBreakMonday());
		if ($facility -> getBreakTuesday() != null)
			$facility -> addBusinesshour($facility -> getBreakTuesday());
		if ($facility -> getBreakWednesday() != null)
			$facility -> addBusinesshour($facility -> getBreakWednesday());
		if ($facility -> getBreakThursday() != null)
			$facility -> addBusinesshour($facility -> getBreakThursday());
		if ($facility -> getBreakFriday() != null)
			$facility -> addBusinesshour($facility -> getBreakFriday());
		if ($facility -> getBreakSaturday() != null)
			$facility -> addBusinesshour($facility -> getBreakSaturday());
		if ($facility -> getBreakSunday() != null)
			$facility -> addBusinesshour($facility -> getBreakSunday());
	}

	private function constructBusinesshours($facility, $phase, $dayofweek) {
		$businesshours = new Businesshours;
		$businesshours -> setId($this -> generateUuid());
		$businesshours -> setFacility($facility);
		$businesshours -> setPhase($phase);
		$businesshours -> setDayofweek($dayofweek);
		$businesshours -> setOpen(FALSE);
		$businesshours -> setOpeningtime(null);
		$businesshours -> setClosingtime(null);
		return $businesshours;
	}

}
