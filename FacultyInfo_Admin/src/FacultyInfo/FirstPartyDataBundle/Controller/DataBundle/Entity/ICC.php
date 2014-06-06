<?php
namespace AIESEC\Portal\DataBundle\Entity;

class ICC {
	private $id;
	private $name;
	private $active;
	private $city;
	private $startDate;
	private $endDate;
	private $registrationLink;
	
	function __construct($id,$name,$active,$city,$startDate,$endDate,$registrationLink){
		$this->id = $id;
		$this->name = $name;
		$this->active = $active;
		$this->city = $city;
		$this->startDate = $this->formatToDateTime($startDate);
		$this->endDate = $this->formatToDateTime($endDate);
		$this->registrationLink = $registrationLink;
	}

	private function formatToDateTime($date){
		if(is_string($date))
			return new \DateTime($date);
		else if(is_object($date) && $date instanceof \DateTime)
			return $date;
		return null;
	}

	public function getId(){
		return $this->id;
	}
	public function getName(){
	    return $this->name;
	}
	public function isActive(){
		return $this->active;
	}
	public function getCity(){
		return $this->city;
	}
	public function getStartDate(){
		return $this->startDate;
	}
	public function getEndDate(){
		return $this->endDate;
	}
	public function getRegistrationLink(){
		return $this->registrationLink;
	}
}