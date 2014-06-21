<?php

namespace FacultyInfo\FirstPartyDataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

class BusinesshoursFacility {
	const TYPE_CAFETERIA = 1;
	const TYPE_LIBRARY = 2;

	private $id;
	private $name;
	private $type;

	private $businesshours;

	private $semesterMonday;
	private $semesterTuesday;
	private $semesterWednesday;
	private $semesterThursday;
	private $semesterFriday;
	private $semesterSaturday;
	private $semesterSunday;

	private $breakMonday;
	private $breakTuesday;
	private $breakWednesday;
	private $breakThursday;
	private $breakFriday;
	private $breakSaturday;
	private $breakSunday;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this -> businesshours = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Set id
	 *
	 * @param string $id
	 * @return BusinesshoursFacility
	 */
	public function setId($id) {
		$this -> id = $id;

		return $this;
	}

	/**
	 * Get id
	 *
	 * @return string
	 */
	public function getId() {
		return $this -> id;
	}

	/**
	 * Set name
	 *
	 * @param string $name
	 * @return BusinesshoursFacility
	 */
	public function setName($name) {
		$this -> name = $name;

		return $this;
	}

	/**
	 * Get name
	 *
	 * @return string
	 */
	public function getName() {
		return $this -> name;
	}

	/**
	 * Set type
	 *
	 * @param integer $type
	 * @return BusinesshoursFacility
	 */
	public function setType($type) {
		$this -> type = $type;

		return $this;
	}

	/**
	 * Get type
	 *
	 * @return integer
	 */
	public function getType() {
		return $this -> type;
	}

	/**
	 * Add businesshours
	 *
	 * @param \FacultyInfo\FirstPartyDataBundle\Entity\Businesshours $businesshours
	 * @return BusinesshoursFacility
	 */
	public function addBusinesshour(\FacultyInfo\FirstPartyDataBundle\Entity\Businesshours $businesshours) {
		$this -> businesshours[] = $businesshours;

		return $this;
	}

	/**
	 * Remove businesshours
	 *
	 * @param \FacultyInfo\FirstPartyDataBundle\Entity\Businesshours $businesshours
	 */
	public function removeBusinesshour(\FacultyInfo\FirstPartyDataBundle\Entity\Businesshours $businesshours) {
		$this -> businesshours -> removeElement($businesshours);
	}

	/**
	 * Get businesshours
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getBusinesshours() {
		return $this -> businesshours;
	}

	public function getSemesterMonday() {
		return $this -> semesterMonday;
	}

	public function setSemesterMonday(\FacultyInfo\FirstPartyDataBundle\Entity\Businesshours $semesterMonday) {
		$this -> semesterMonday = $semesterMonday;
	}

	public function getSemesterTuesday() {
		return $this -> semesterTuesday;
	}

	public function setSemesterTuesday(\FacultyInfo\FirstPartyDataBundle\Entity\Businesshours $semesterTuesday) {
		$this -> semesterTuesday = $semesterTuesday;
	}

	public function getSemesterWednesday() {
		return $this -> semesterWednesday;
	}

	public function setSemesterWednesday(\FacultyInfo\FirstPartyDataBundle\Entity\Businesshours $semesterWednesday) {
		$this -> semesterWednesday = $semesterWednesday;
	}
	
	public function getSemesterThursday() {
		return $this->semesterThursday;
	}
	
	public function setSemesterThursday(\FacultyInfo\FirstPartyDataBundle\Entity\Businesshours $semesterThursday) {
		$this->semesterThursday = $semesterThursday;
	}
	
	public function getSemesterFriday() {
		return $this->semesterFriday;
	}
	
	public function setSemesterFriday(\FacultyInfo\FirstPartyDataBundle\Entity\Businesshours $semesterFriday) {
		$this->semesterFriday = $semesterFriday;
	}
	
	public function getSemesterSaturday() {
		return $this->semesterSaturday;
	}
	
	public function setSemesterSaturday(\FacultyInfo\FirstPartyDataBundle\Entity\Businesshours $semesterSaturday) {
		$this->semesterSaturday = $semesterSaturday;
	}
	
	public function getSemesterSunday() {
		return $this->semesterSunday;
	}
	
	public function setSemesterSunday(\FacultyInfo\FirstPartyDataBundle\Entity\Businesshours $semesterSunday) {
		$this->semesterSunday = $semesterSunday;
	}
	
	public function getBreakMonday() {
		return $this->breakMonday;
	}
	
	public function setBreakMonday(\FacultyInfo\FirstPartyDataBundle\Entity\Businesshours $breakMonday) {
		$this->breakMonday = $breakMonday;
	}
	
	public function getBreakTuesday() {
		return $this->breakTuesday;
	}
	
	public function setBreakTuesday(\FacultyInfo\FirstPartyDataBundle\Entity\Businesshours $breakTuesday) {
		$this->breakTuesday = $breakTuesday;
	}
	
	public function getBreakWednesday() {
		return $this->breakWednesday;
	}
	
	public function setBreakWednesday(\FacultyInfo\FirstPartyDataBundle\Entity\Businesshours $breakWednesday) {
		$this->breakWednesday = $breakWednesday;
	}
	
	public function getBreakThursday() {
		return $this->breakThursday;
	}
	
	public function setBreakThursday(\FacultyInfo\FirstPartyDataBundle\Entity\Businesshours $breakThursday) {
		$this->breakThursday = $breakThursday;
	}
	
	public function getBreakFriday() {
		return $this->breakFriday;
	}
	
	public function setBreakFriday(\FacultyInfo\FirstPartyDataBundle\Entity\Businesshours $breakFriday) {
		$this->breakFriday = $breakFriday;
	}
	
	public function getBreakSaturday() {
		return $this->breakSaturday;
	}
	
	public function setBreakSaturday(\FacultyInfo\FirstPartyDataBundle\Entity\Businesshours $breakSaturday) {
		$this->breakSaturday = $breakSaturday;
	}
	
		public function getBreakSunday() {
		return $this->breakSunday;
	}
	
	public function setBreakSunday(\FacultyInfo\FirstPartyDataBundle\Entity\Businesshours $breakSunday) {
		$this->breakSunday = $breakSunday;
	}
}