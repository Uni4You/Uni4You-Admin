<?php
namespace AIESEC\Portal\DataBundle\Entity;
require 'API_Object.php';
use AIESEC\Portal\DataBundle\Service;

/**
 *
 * @author Felix Goroncy
 *
 * 2014/05/29 - created
 */
class Opportunity extends API_Object {
	private $title;
	//holds an url as link to an application form
	private $applicationForm;
	private $cityLc;
	private $closingDate;
	private $openingDate;
	//holds id of contact person account
	private $contactPerson;
	//holds name of contact person (from account)
	private $contactPersonName;
	private $contactEmail;
	private $contactPhone;
	private $description;
	private $currentlyOpen;
	private $requirements;
	private $scope;
	private $subtitle;
	private $subtype;
	private $type;
	
	public function getTitle(){
		return (is_null($this->title)? "":$this->title);
	}
	public function setTitle($title){
		if(is_null($title) || is_string($title))
			$this->title = $title;
	}
	
	public function getApplicationForm(){
		return (is_null($this->applicationForm)? "":$this->applicationForm);
	}
	public function setApplicationForm($form){
		if(is_null($form) || is_string($form))
			$this->applicationForm = $form;
	}
	
	public function getCityLc(){
		return $this->cityLc;
	}
	public function setCityLc($cityLc){
		$this->cityLc = $cityLc;
	}
	
	public function getOpeningDate(){
		return $this->openingDate;
	}
	public function setOpeningDate($date){
		$this->openingDate = self::formatToDateTime($date);
	}
	
	public function getClosingDate(){
		return $this->closingDate;
	}
	public function setClosingDate($date){
		$this->closingDate = self::formatToDateTime($date);
	}
	
	public function getContactPerson(){
		return $this->contactPerson;
	}
	public function setContactPerson($person){
		$this->contactPerson = $person;
	}
	
	public function getContactPersonName(){
		return (is_null($this->contactPersonName)? "":$this->contactPersonName);
	}
	public function setContactPersonName($name){
		if(is_null($name) || is_string($name))
			$this->contactPersonName = $name;
	}

	public function getContactEmail(){
		return (is_null($this->contactEmail)? "":$this->contactEmail);
	}
	public function setContactEmail($email){
		if(is_null($email) || is_string($email))
			$this->contactEmail = $email;
	}
	
	public function getContactPhone(){
		return (is_null($this->contactPhone)? "":"".$this->contactPhone);
	}
	public function setContactPhone($phone){
		if(is_null($phone) || is_string($phone) || is_integer($phone))
			$this->contactPhone = $phone;
	}
	
	public function getDescription(){
		return (is_null($this->description)? "":$this->description);
	}
	public function setDescription($description){
		if(is_null($description) || is_string($description))
			$this->description = $description;
	}
	
	public function isCurrentlyOpen(){
		return ($this->currentlyOpen === true);
	}
	public function setCurrentlyOpen($open){
		if(is_bool($open))
			$this->currentlyOpen = $open;
		else
			throw new InvalidArgumentException("Argument must be of type boolean!");
	}
	
	public function getRequirements(){
		return (is_null($this->requirements)? "":$this->requirements);
	}
	public function setRequirements($requirements){
		if(is_null($requirements) || is_string($requirements))
			$this->requirements = $requirements;
		else
			throw new InvalidArgumentException("Argument must be of type string or null!");
	}
	
	public function getScope(){
		return $this->scope;
	}
	public function setScope($scope){
		if(is_null($scope) || is_integer($scope))
			$this->scope = $scope;
		else
			return new InvalidArgumentException("Argument must be of type array or null!");
	}
	
	public function getSubtitle(){
		return $this->subtitle;
	}
	public function setSubtitle($subtitle){
		if(is_null($subtitle) || is_string($subtitle))
			$this->subtitle = $subtitle;
		else
			return new InvalidArgumentException("Argument must be of type string or null!");
	}
	
	public function getSubType(){
		return $this->subtype;
	}
	public function setSubType($subtype){
		if(is_null($subtype) || is_integer($subtype))
			$this->subtype = $subtype;
		else
			return new InvalidArgumentException("Argument must be of type array or null!");
	}
	
	public function getType(){
		return $this->type;
	}
	public function setType($type){
		if(is_null($type) || is_integer($type))
			$this->type = $type;
		else
			return new InvalidArgumentException("Argument must be of type array or null!");
	}
}