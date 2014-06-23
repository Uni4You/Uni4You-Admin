<?php

namespace FacultyInfo\FirstPartyDataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class Businesshours {
	const DAYOFWEEK_MONDAY = 1;
	const DAYOFWEEK_TUESDAY = 2;
	const DAYOFWEEK_WEDNESDAY = 3;
	const DAYOFWEEK_THURSDAY = 4;
	const DAYOFWEEK_FRIDAY = 5;
	const DAYOFWEEK_SATURDAY = 6;
	const DAYOFWEEK_SUNDAY = 7;
	const PHASE_SEMESTER = 1;
	const PHASE_BREAK = 2;
	const STATUS_OPEN = 1;
	const STATUS_CLOSED = 2;

	private $id;
	private $dayofweek;
	private $phase;
	private $status;
	private $timestamp;
	
	/**
	 * @Assert\NotBlank(groups={"time_required"})
	 */
	private $openingtime;
	/**
	 * @Assert\NotBlank(groups={"time_required"})
	 */
	private $closingtime;

	private $facility;

	/**
	 * Set id
	 *
	 * @param string $id
	 * @return Businesshours
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
	 * Set dayofweek
	 *
	 * @param integer $dayofweek
	 * @return Businesshours
	 */
	public function setDayofweek($dayofweek) {
		$this -> dayofweek = $dayofweek;

		return $this;
	}

	/**
	 * Get dayofweek
	 *
	 * @return integer
	 */
	public function getDayofweek() {
		return $this -> dayofweek;
	}

	/**
	 * Set phase
	 *
	 * @param integer $phase
	 * @return Businesshours
	 */
	public function setPhase($phase) {
		$this -> phase = $phase;

		return $this;
	}

	/**
	 * Get phase
	 *
	 * @return integer
	 */
	public function getPhase() {
		return $this -> phase;
	}

	/**
	 * Set status
	 *
	 * @param integer $status
	 * @return Businesshours
	 */
	public function setStatus($status) {
		$this -> status = $status;

		return $this;
	}

	/**
	 * Get status
	 *
	 * @return integer
	 */
	public function getStatus() {
		return $this -> status;
	}

	public function isOpen() {
		return $this -> status === Businesshours::STATUS_OPEN;
	}

	public function setOpen($isOpen) {
		$this -> setStatus($isOpen ? Businesshours::STATUS_OPEN : Businesshours::STATUS_CLOSED);
	}

	/**
	 * Set openingtime
	 *
	 * @param \DateTime $openingtime
	 * @return Businesshours
	 */
	public function setOpeningtime($openingtime) {
		$this -> openingtime = $openingtime;

		return $this;
	}

	/**
	 * Get openingtime
	 *
	 * @return \DateTime
	 */
	public function getOpeningtime() {
		return $this -> openingtime;
	}

	/**
	 * Set closingtime
	 *
	 * @param \DateTime $closingtime
	 * @return Businesshours
	 */
	public function setClosingtime($closingtime) {
		$this -> closingtime = $closingtime;

		return $this;
	}

	/**
	 * Get closingtime
	 *
	 * @return \DateTime
	 */
	public function getClosingtime() {
		return $this -> closingtime;
	}

	/**
	 * Set facility
	 *
	 * @param \FacultyInfo\FirstPartyDataBundle\Entity\BusinesshoursFacility $facility
	 * @return Businesshours
	 */
	public function setFacility(\FacultyInfo\FirstPartyDataBundle\Entity\BusinesshoursFacility $facility = null) {
		$this -> facility = $facility;

		return $this;
	}

	/**
	 * Get facility
	 *
	 * @return \FacultyInfo\FirstPartyDataBundle\Entity\BusinesshoursFacility
	 */
	public function getFacility() {
		return $this -> facility;
	}


    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return Businesshours
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime 
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
}
