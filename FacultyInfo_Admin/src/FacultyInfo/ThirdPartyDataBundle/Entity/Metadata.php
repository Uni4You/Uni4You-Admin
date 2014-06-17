<?php

namespace FacultyInfo\ThirdPartyDataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class Metadata {
	const NAME_BUSINESSHOURS = "businesshours";
	const NAME_FAQ = "faq";
	const NAME_BUSLINE = "busline";
	const NAME_CONTACTPERSON = "contactperson";
	const NAME_EVENT = "event";
	const NAME_MAPMARKER = "mapmarker";
	const NAME_MENU = "menu";
	const NAME_NEWS = "news";
	const NAME_SPORTSCOURSE = "sportscourse";

	private $name;
	private $isThirdPartyData;
	private $lastStatuscode;
	private $lastUpdate;
	private $sourceUrl;

	/**
	 * Set name
	 *
	 * @param string $name
	 * @return Metadata
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
	 * Set isThirdPartyData
	 *
	 * @param boolean $isThirdPartyData
	 * @return Metadata
	 */
	public function setIsThirdPartyData($isThirdPartyData) {
		$this -> isThirdPartyData = $isThirdPartyData;

		return $this;
	}

	/**
	 * Get isThirdPartyData
	 *
	 * @return boolean
	 */
	public function getIsThirdPartyData() {
		return $this -> isThirdPartyData;
	}

	/**
	 * Set lastStatuscode
	 *
	 * @param integer $lastStatuscode
	 * @return Metadata
	 */
	public function setLastStatuscode($lastStatuscode) {
		$this -> lastStatuscode = $lastStatuscode;

		return $this;
	}

	/**
	 * Get lastStatuscode
	 *
	 * @return integer
	 */
	public function getLastStatuscode() {
		return $this -> lastStatuscode;
	}

	/**
	 * Set lastUpdate
	 *
	 * @param \DateTime $lastUpdate
	 * @return Metadata
	 */
	public function setLastUpdate($lastUpdate) {
		$this -> lastUpdate = $lastUpdate;

		return $this;
	}

	/**
	 * Get lastUpdate
	 *
	 * @return \DateTime
	 */
	public function getLastUpdate() {
		return $this -> lastUpdate;
	}

	/**
	 * Set sourceUrl
	 *
	 * @param string $sourceUrl
	 * @return Metadata
	 */
	public function setSourceUrl($sourceUrl) {
		$this -> sourceUrl = $sourceUrl;

		return $this;
	}

	/**
	 * Get sourceUrl
	 *
	 * @return string
	 */
	public function getSourceUrl() {
		return $this -> sourceUrl;
	}

}
