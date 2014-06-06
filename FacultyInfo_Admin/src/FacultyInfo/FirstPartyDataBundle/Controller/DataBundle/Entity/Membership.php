<?php
namespace AIESEC\Portal\DataBundle\Entity;
use AIESEC\Portal\DataBundle\Service;
use AIESEC\Portal\DataBundle\Service\DBConstants;

/**
 * 
 * @author Felix Goroncy
 *
 * 2014/04/27 - created
 */
class Membership
{
	const EXCHANGE_TYPE_NONE = null;
	const EXCHANGE_TYPE_GIP = 0;
	const EXCHANGE_TYPE_GCDP = 1;
	
	const MEMBER_TYPE_ACTIVE = 0;
	const MEMBER_TYPE_ALUMNI = 1;
	
	/** For the case of salesforce as backend
	 *  this number equals the account's sId */
	private $sId;
	private $memberType;
	
	private $dateOfJoining;
	private $spendSemesterAbroad;
	private $skypeId;
	private $hasDriversLicense;
	private $requestedWorkshops;
	private $hasInterestedInTLP;
	private $detailsTLP;
	private $hasInterestInExchange;
	private $typeOfExchange;
	private $possibleStartOfExchange;
	private $detailsExchange;
	private $hasInterestInTrainerEducation;
	private $detailsTrainerEducation;
	private $ableToHostInterns;
	private $hasCar;
	
	/** array of all career steps of member */
	private $jobs;
	
	public function __construct(){
		//set defaults
		$this->memberType = self::MEMBER_TYPE_ALUMNI;
		
		//default in case deep database access was not performed
		$this->jobs = false;
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
	
	public function setSId($sId){ $this->sId = $sId; }
	public function getSId(){ return $this->sId;}
	
	public function setMemberType($type){
		if($type === self::MEMBER_TYPE_ACTIVE ||
			$type === self::MEMBER_TYPE_ALUMNI){
			$this->memberType = $type;
		}
	}
	
	public function getMemberType(){
		return $this->memberType;
	}
	
	/**
	 * Sets jobs for this instance or an empty
	 * array if passed argument is null.
	 * 
	 * @param array $jobs 
	 */
	public function setJobs($jobs){
		if(is_null($jobs)){
			$this->jobs = array();
		}elseif(is_array($jobs)){
			$this->jobs = $jobs;
		}
	}
	
	public function getJobs(){ return $this->jobs; }
	
    /**
     * Function sets date of joining.
     * $dateOfJoining can be one of the following 3 types
     * -null: internal variable is set to null
     * -string containing date: internal variable is
     * set to DateTime object constructed by $dateOfJoining
     * -instance of DateTime: internal variable is set
     * to passed-in instance
     */
	public function setDateOfJoining($dateOfJoining){
		$this->dateOfJoining = $this->formatToDateTime($dateOfJoining);
	}
	
	public function getDateOfJoining(){ return $this->dateOfJoining; }
	
	
	public function setHasSpendSemesterAbroad($spendSemesterAbroad){
		if(is_bool($spendSemesterAbroad)){
			$this->spendSemesterAbroad = $spendSemesterAbroad;
		}else{
			throw new \Exception('Function expects passed parameter to be of type boolean!');
		}
	}
	public function getHasSpendSemesterAbroad(){
		//makes sure to return boolean value even if not set before
		return $this->spendSemesterAbroad === true;
	}
	
	public function setSkypeId($skypeId){
		$this->skypeId = $skypeId;
	}
	public function getSkypeId(){ return $this->skypeId; }
	
	public function setHasDriversLicense($hasDriversLicense){
		if(is_bool($hasDriversLicense)){
			$this->hasDriversLicense = $hasDriversLicense;
		}else{
			throw new \Exception('Function expects passed parameter to be of type boolean!');
		}
	}
	public function getHasDriversLicense(){
		//makes sure to return boolean value even if not set before
		return $this->hasDriversLicense === true;
	}

	
	// ========== Information on Team Leadership Position ==========
	public function setHasInterestedInTLP($hasInterestedInTLP){
		if(is_bool($hasInterestedInTLP)){
			$this->hasInterestedInTLP = $hasInterestedInTLP;
		}else{
			throw new \Exception('Function expects passed parameter to be of type boolean!');
		}
	}
	public function getHasInterestedInTLP(){
		//makes sure to return boolean value even if not set before
		return $this->hasInterestedInTLP === true;
	}
	
	public function setDetailsTLP($details){
		if(is_null($details) || is_string($details))
			$this->detailsTLP = $details;
	}
	/**
	 * Returns details about desired team leadership position or an
	 * empty string.
	 * @return string details about TLP
	 */
	public function getDetailsTLP(){
		return (is_null($this->detailsTLP)? "":$this->detailsTLP);
	}
	// ================ End Team Leadership Position ================
	
	public function setRequestedWorkshops($workshops){
		if(is_null($workshops) || is_array($workshops)){
			$this->requestedWorkshops = $workshops;
		}else{
			throw new Exception('Function expects passed parameter to be of type array or null!');
		}
	}
	
	/**
	 * Function returns array of all requested workshops of the
	 * member or an empty array if nothing is specified.
	 * @return array of requested workshops
	 */
	public function getRequestedWorkshops(){
		return (is_null($this->requestedWorkshops)? array():$this->requestedWorkshops);
	}
	
	// ========== Information on Interest in Exchange ==========
	public function setHasInterestInExchange($interest){
		if(is_bool($interest)){
			$this->hasInterestInExchange = $interest;
		}else{
			throw new \Exception('Function expects passed parameter to be of type boolean!');
		}
	}
	
	public function getHasInterestInExchange(){
		return $this->hasInterestInExchange === true;
	}
	
	public function setPossibleStartOfExchange($startOfExchange){
		$this->possibleStartOfExchange = $this->formatToDateTime($startOfExchange);
	}
	
	public function getPossibleStartOfExchange(){
		return $this->possibleStartOfExchange;
	}
	
	public function setTypeOfExchange($type){
		$argumentValid =
			$type == self::EXCHANGE_TYPE_NONE ||
			$type == self::EXCHANGE_TYPE_GCDP ||
			$type == self::EXCHANGE_TYPE_GIP;
		
		if(!$argumentValid){
			throw new \Exception('Invalid value for argument. Use Class constants!');
		}
		
		$this->typeOfExchange = $type;
	}
	
	public function getTypeOfExchange(){
		return $this->typeOfExchange;
	}
	
	public function setDetailsExchange($details){
		if(is_null($details) || is_string($details)){
			$this->detailsExchange = $details;
		}
	}
	
	public function getDetailsExchange(){
		return (is_null($this->detailsExchange)? "":$this->detailsExchange);
	}
		
	// ============== End of Interest in Exchange ==============
	
	// ===== Information on Interest in Trainer Education ======
	public function setHasInterestInTrainerEducation($interest){
		if(is_bool($interest)){
			$this->hasInterestInTrainerEducation = $interest;
		}else{
			throw new \Exception('Function expects passed parameter to be of type boolean!');
		}
	}
	public function getHasInterestInTrainerEducation(){
		return $this->hasInterestInTrainerEducation === true;
	}
	
	public function setDetailsTrainerEducation($details){
		if(is_null($details) || is_string($details)){
			$this->detailsTrainerEducation = $details;
		}
	}
	
	public function getDetailsTrainerEducation(){
		return (is_null($this->detailsTrainerEducation)? "":$this->detailsTrainerEducation);
	}

	// ========== End of Interest in Trainer Education =========
	
	public function setAbleToHostInterns($canHost){
		if(is_bool($canHost)){
			$this->ableToHostInterns = $canHost;
		}else{
			throw new \Exception('Function expects passed parameter to be of type boolean!');
		}
	}
	public function isAbleToHostInterns(){
		return $this->ableToHostInterns === true;
	}
	
	public function setHasCar($hasCar){
		if(is_bool($hasCar)){
			$this->hasCar = $hasCar;
		}else{
			throw new \Exception('Function expects passed parameter to be of type boolean!');
		}
	}
	public function getHasCar(){
		return $this->hasCar === true;
	}
}