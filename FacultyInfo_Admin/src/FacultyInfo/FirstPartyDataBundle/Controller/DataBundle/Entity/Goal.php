<?php
namespace AIESEC\Portal\DataBundle\Entity;
require 'API_Object.php';
use AIESEC\Portal\DataBundle\Service;
use Doctrine\Common\Proxy\Exception\InvalidArgumentException;

/**
 *
 * @author Felix Goroncy
 *
 * 2014/06/02 - created
 */
class Goal extends API_Object {
	/** Name for the Goal */
	private $name;
	/** Id of parent object in database */
	private $jobId;
	/** Description of current state of the goal */
	private $currentState;
	/** Description of the goal */
	private $description;
	/** date the fulfillment of the goal is due */
	private $dueDate;
	/** Value of fulfillment [0.0,100.0] */
	private $percentage;
	/** Index of goal type array */
	private $type;
	/** Index of goal subtype array */
	private $subtype;

	
	public function setName($name){
		if(is_null($name) || is_string($name))
			$this->name = $name;
		else
			throw new InvalidArgumentException("Argument has to be of type string or null!");
	}
	public function getName(){
		return (is_null($this->name)? "":$this->name);
	}
	
	public function setJobId($jobId){
		$this->jobId = $jobId;
	}
	public function getJobId(){
		return $this->jobId;
	}

	public function setCurrentState($currentState){
		if(is_null($currentState) || is_string($currentState))
			$this->currentState = $currentState;
		else
			throw new \InvalidArgumentException("Argument has to be of type string or null");
	}
	public function getCurrentState(){
		return (is_null($this->currentState)? "":$this->currentState);
	}
	
	public function setDescription($description){
		if(is_null($description) || is_string($description))
			$this->description = $description;
		else
			throw new \InvalidArgumentException("Argument has to be of type string or null");
	}
	public function getDescription(){
		return (is_null($this->description)? "":$this->description);
	}
	
	public function setDueDate($date){
		$this->dueDate = parent::formatToDateTime($date);
	}
	public function getDueDate(){
		return $this->dueDate;
	}
	
	public function setPercentage($percentage){
		if(is_null($percentage) || is_int($percentage) || is_float($percentage))
			$this->percentage = $percentage;
		else
			throw new \InvalidArgumentException("Argument has to be of type int, float or null");
	}
	public function getPercentage(){
		return (is_null($this->percentage)? 0:$this->percentage);
	}
	
	public function setType($type){
		$this->type = $type;
	}
	public function getType(){
		return $this->type;
	}
	
	public function setSubtype($subtype){
		$this->subtype = $subtype;
	}
	public function getSubtype(){
		return $this->subtype;
	}
}