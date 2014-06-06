<?php
namespace AIESEC\Portal\DataBundle\Entity;
use AIESEC\Portal\DataBundle\Service;
use Symfony\Component\Validator\Constraints\IbanValidator;
use Doctrine\Common\Proxy\Exception\InvalidArgumentException;

/**
 * 
 * @author Felix Goroncy
 *
 * 2014/04/27 - created
 */
class Job
{
	const YOUTH_TALENT_PROGRAM_SOCIAL_SALES = 0;
	const YOUTH_TALENT_PROGRAM_DEVELOPMENT = 1;
	const YOUTH_TALENT_PROGRAM_PROJECTS = 2;
	const YOUTH_TALENT_PROGRAM_ADMINISTRATION = 3;
	
	const TEAM_TYPE_LOCAL = 0;
	const TEAM_TYPE_NATIONAL = 1;
	const TEAM_TYPE_INTERNATIONAL = 2;
	
	//local subtypes
	const TEAM_SUBTYPE_ER = 0;
	const TEAM_SUBTYPE_TM = 1;
	const TEAM_SUBTYPE_ICX = 2;
	const TEAM_SUBTYPE_IGCDP = 3;
	const TEAM_SUBTYPE_OGX = 4;
	const TEAM_SUBTYPE_OGIP = 5;
	const TEAM_SUBTYPE_OGCDP = 6;
	const TEAM_SUBTYPE_FIN = 7;
	const TEAM_SUBTYPE_COM = 8;
	const TEAM_SUBTYPE_REC = 9;
	
	//national subtypes
	const TEAM_SUBTYPE_NIST = 16; // leave some values open between local subtypes
	const TEAM_SUBTYPE_NST_ER = 17;
	const TEAM_SUBTYPE_NST_TM = 18;
	const TEAM_SUBTYPE_NST_ICX = 19;
	const TEAM_SUBTYPE_NST_OGIP = 20;
	const TEAM_SUBTYPE_NST_OGCDP = 21;
	const TEAM_SUBTYPE_NST_FIN = 22;
	const TEAM_SUBTYPE_NST_COM = 23;
	const TEAM_SUBTYPE_NST_OD = 24;
	const TEAM_SUBTYPE_NST_BD = 25;
	const TEAM_SUBTYPE_NTT = 26;
	const TEAM_SUBTYPE_REGIO_CO = 27;
	const TEAM_SUBTYPE_RLP = 28;
	const TEAM_SUBTYPE_MC = 29;
	
	//for multiple types
	const TEAM_SUBTYPE_OTHER = 32;
	const TEAM_SUBTYPE_OC = 33;
	
	const POSITION_MEMBER = 0;
	const POSITION_TEAM_LEADER = 1;
	const POSITION_VICE_PRESIDENT = 2;
	const POSITION_PRESIDENT = 3;
	
	public static $TEAM_SUB_TYPES = array(
			self::TEAM_TYPE_LOCAL => array(
				self::TEAM_SUBTYPE_ER,
				self::TEAM_SUBTYPE_TM,
				self::TEAM_SUBTYPE_ICX,
				self::TEAM_SUBTYPE_IGCDP,
				self::TEAM_SUBTYPE_OGX,
				self::TEAM_SUBTYPE_OGIP,
				self::TEAM_SUBTYPE_OGCDP,
				self::TEAM_SUBTYPE_FIN,
				self::TEAM_SUBTYPE_COM,
				self::TEAM_SUBTYPE_REC,
				self::TEAM_SUBTYPE_OTHER,
				self::TEAM_SUBTYPE_OC,
			),
			self::TEAM_TYPE_NATIONAL => array(
				self::TEAM_SUBTYPE_NIST,
				self::TEAM_SUBTYPE_NST_ER,
				self::TEAM_SUBTYPE_NST_TM,
				self::TEAM_SUBTYPE_NST_ICX,
				self::TEAM_SUBTYPE_NST_OGIP,
				self::TEAM_SUBTYPE_NST_OGCDP,
				self::TEAM_SUBTYPE_NST_FIN,
				self::TEAM_SUBTYPE_NST_COM,
				self::TEAM_SUBTYPE_NST_OD,
				self::TEAM_SUBTYPE_NST_BD,
				self::TEAM_SUBTYPE_NTT,
				self::TEAM_SUBTYPE_REGIO_CO,
				self::TEAM_SUBTYPE_RLP,
				self::TEAM_SUBTYPE_MC,
				self::TEAM_SUBTYPE_OTHER,
				self::TEAM_SUBTYPE_OC,
			),
			self::TEAM_TYPE_INTERNATIONAL => array(
				self::TEAM_SUBTYPE_OTHER,
				self::TEAM_SUBTYPE_OC,
			)
	);
	
	/** database id of job object */
	private $id;
	/** Name of the career step */
	private $jobName;
	/** Start date of career step */
	private $dateStarted;
	/** End date of career step or null if still active
	 * TODO: create isActive method as well */
	private $dateEnded;
	/** Email address used for the function of the job (if active) */
	private $functionalEmail;
	/** Reference to member acting as last responsible leader during the period of the job 
	 *  TODO: Think about what kind of reference is needed here (maybe account ID) */
	private $teamLeader;
	/** Which program does/did this membership belong to. */
	private $youthTalentProgram;
	/** Which local committee does/did this membership take place 
	 * TODO: at the moment an integer value will be saved (index to corresponding array
	 * in DBValuesMembership). It remains to be tested if there will be problems with the
	 * corresponding form! */
	private $lc;
	/** team type this membership belongs/-ed to. */
	private $teamType;
	/** Subtype of Team the member is/was in. */
	private $teamSubType;
	/** The name of the team. */
	private $teamName;
	private $position;
	private $positionName;
	private $jobDescription;
	private $timeInvested;
	
	private $goals;
	
	/*
	 * pdts and conferences are not to be displayed on the platform at the
	 * moment and will be omitted
	 * 
	 *private $pdts;
	 *private $conferencesParticipated;
	 */
	
	public function __construct(){
		$this->team = self::TEAM_TYPE_LOCAL;
		$this->teamSubType = self::TEAM_SUBTYPE_OTHER;
		
		/*
		 * In case not all data is loaded (reduce database access)
		 * with object creatio set default to false.
		 */
		$this->pdts = false;
		$this->conferencesParticipated = false;
		$this->goals = false;
	}
		
	/**
	 * Conversion function for all time based properties.
	 * TODO: outsource to central location to use single
	 * function for all entity objects!
	 * 
	 * @param mixed $date
	 * @return \DateTime|NULL
	 */
	private function formatToDateTime ($date)
	{
		if (is_string($date))
			return new \DateTime($date);
		else
		if (is_object($date) && $date instanceof \DateTime)
			return $date;
		return null;
	}
	
	public function isActive(){
		return $this->dateEnded === null;
	}
	
	public function setId($id){
		//should never be int for salesforce but might be when database is changed
		if(is_string($id) || is_int($id))
			$this->id = $id;
	}
	
	public function getId(){
		return $this->id;
	}

	public function setJobName($jobName){
		if(is_null($jobName) || is_string($jobName)){
			$this->jobName = $jobName;
		}
	}
	public function getJobName(){
		return (is_null($this->jobName)? "":$this->jobName);
	}
	
	public function setDateStarted($date){
		$this->dateStarted = $this->formatToDateTime($date);
	}
	public function getDateStarted(){
		return $this->dateStarted;
	}

	public function setDateEnded($date){
		$this->dateEnded = $this->formatToDateTime($date);
	}
	public function getDateEnded(){
		return $this->dateEnded;
	}
	
	public function setFunctionalEmail($email){
		if(is_null($email) || is_string($email)){
			$this->functionalEmail = $email;
		}
	}
	public function getFunctionalEmail(){
		return (is_null($this->functionalEmail)? "":$this->functionalEmail);
	}

	/**
	 * The team leader field expects a salesforce id only since
	 * loading more information would mean to use subqueries which
	 * means more database access and thus increases response time
	 * (as well as causing database shutdown incase we reach our
	 * daily limits. It has to be determined whether subqueries count
	 * as additional access or as one) and wastes more memory to store
	 * the object even though the details might not be needed.
	 * <p/>A corresponding function will be implemented to load
	 * team information later on if desired.
	 * 
	 * @param String $leader salesforce id of team leader field in
	 * salesforce's job object.
	 */
	public function setTeamLeader($leader){
		if(is_string($leader)){
			$this->teamLeader = $leader;
		}
	}
	public function getTeamLeader(){
		return $this->teamLeader;
	}
	
	public function setYouthTalentProgram($program){
		if(is_int($program) &&
			$program >= self::YOUTH_TALENT_PROGRAM_SOCIAL_SALES &&
			$program <= self::YOUTH_TALENT_PROGRAM_ADMINISTRATION){
			$this->youthTalentProgram = $program;
		}
	}
	public function getYouthTalentProgram(){
		return $this->youthTalentProgram;
	}
	
	/**
	 * Sets the lc of the career path. As this is a picklist it will be
	 * tested first if saving the index to the corresponding array is enough.
	 * 
	 * @param integer $lc
	 */
	public function setLc($lc){
		$this->lc = $lc;
	}
	public function getLc(){
		return $this->lc;
	}
	
	public function setTeamType($teamType){
		if($teamType === self::TEAM_TYPE_LOCAL ||
			$teamType === self::TEAM_TYPE_NATIONAL ||
			$teamType === self::TEAM_TYPE_INTERNATIONAL){
			$this->team = $teamType;
		}else{
			throw new \Exception('Invalid argument. Use class constants!');
		}
	}
	
	public function getTeamType(){
		return $this->teamType;
	}
	
	public function setTeamSubType($subType){
		//TODO: maybe do some parameter checking first
		$this->teamSubType = $subType;
	}
	public function getTeamSubType(){
		return $this->teamSubType;
	}

	public function setTeamName($teamName){
		if(is_null($teamName) || is_string($teamName))
			$this->teamName = $teamName;
	}
	public function getTeamName(){
		return (is_null($this->teamName)? "":$this->teamName);
	}
	
	public function setPosition($position){
		if(is_int($position) &&
			$position >= self::POSITION_MEMBER &&
			$position <= self::POSITION_PRESIDENT){
			$this->position = $position;
		}
	}
	public function getPosition(){
		return $this->position;
	}

	public function setPositionName($name){
		if(is_null($name) || is_string($name)){
			$this->positionName = $name;
		}
	}
	public function getPositionName(){
		return (is_null($this->positionName)? "":$this->positionName);
	}

	public function setJobDescription($description){
		if(is_null($description) || is_string($description)){
			$this->jobDescription = $description;
		}
	}
	public function getJobDescription(){
		return (is_null($this->jobDescription)? "":$this->jobDescription);
	}

	public function setTimeInvested($timeInvested){
		if(is_int($timeInvested) && $timeInvested >= 0){
			$this->timeInvested = $timeInvested;
		}
	}
	public function getTimeInvested(){
		return $this->timeInvested;
	}
	
	public function setGoals($goals){
		if(is_null($goals) || is_array($goals)){
			$this->goals = $goals;
		}else
			throw new InvalidArgumentException("Argument should be of type array or null!");
	}
	public function getGoals(){
		return $this->goals;
	}
	public function addGoal($goal){
		if($goal instanceof Goal){
			if(!is_array($this->goals))
				$this->goals = array();
			$this->goals[$goal->getId()] = $goal;
		}else 
			throw new \InvalidArgumentException("Argument has to be of type Goal!");
	}
}