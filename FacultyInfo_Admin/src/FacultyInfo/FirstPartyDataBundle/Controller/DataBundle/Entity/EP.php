<?php
namespace AIESEC\Portal\DataBundle\Entity;

use AIESEC\Portal\DataBundle\Service\DBValues;
class EP {
	/**
	 * Constraints from salesforce:
	 * <ol>
	 * <li>AGB Status != "Confirmed"
	 * <li>Amount of Inpayment < 75
	 * </ol>
	 * Filter Logic: 1. OR 2.
	 */
	const STAGE_CONTRACT_PAYMENT = 1;
	
	/**
	 * Constraints from salesforce:
	 * <ol>
	 * <li>EP-Status != ["Realized","Rejected","Expired"]
	 * <li>AGB Status == "Confirmed"
	 * <li>Amount of Inpayment >= 75
	 * </ol>
	 * Filter Logic: 1. AND 2. AND 3.
	 */
	const STAGE_PRE_EXCHANGE = 2;
	
	/**
	 * Constraints from salesforce:
	 * <ol>
	 * <li>Realize Date <= today
	 * <li>EP-Status == "Realized"
	 * <li>Return Date > today
	 * </ol>
	 * Filter Logic: 3. AND (1. OR 2.)
	 */
	const STAGE_EXCHANGE = 3;
	
	/**
	 * Constraints from salesforce:
	 * <ol>
	 * <li>Reintegration Activity completed == "Not Completed"
	 * <li>EP Returned == True
	 * </ol>
	 * Filter Logic: 1. AND 2.
	 */
	const STAGE_POST_EXCHANGE = 4;
	
	const STAGE_FINISHED = 5;
	
	// extracted data from backend
	private $sId;
	private $GIPGCDP;
	private $aiesecEpId;
	private $tnId;
	private $stage;
	
	private $earliestStartDate;
	private $latestEndDate;
	private $minimumDuration;
	private $maximumDuration;
	private $epStatus;
	private $realizeDate;
	private $returnDate;
	private $reintegrationActivityCompleted;
	
	private $AGBLanguage;
	private $AGBVersion;
	private $isAGBUploaded;
	private $dateAGBSigned;
	private $AGBStatus;
	
	private $signedStudentContract;
	private $isANUploaded;
	private $dateANUploaded;
	
	private $isEnrollmentCertificateUploaded;
	private $dateEnrollmentCertificateUploaded;
	
	private $dateExperienceReportUploaded;
	
	//payment
	private $amountICCFee;
	private $amountInpayment;
	private $amountMatchingFee;
	private $amountPEDSFee;
	private $amountRaisingFee;
	private $amountRefunding;
	private $amountRetention;
		
	private $isDisplayedInPortal;
	private $isEditableInPortal;
	
	private $AGBFile;
	private $ANFile;
	private $certificateOfEnrollment;
	private $experienceReportFile;
	public $promotionalPictures =
		array('promo1'=>null,'promo2'=>null,'promo3'=>null,);
	
	// controll via LC member
	/** Value has to be set to valid value by LC via salesforce environment*/
	private $epStatusPreExchange;
	
	function __construct ($sId,
			$GIPGCDP,$aiesecEpId,$tnId,
			$earliestStartDate,$latestEndDate,$minimumDuration,$maximumDuration,
			$epStatus,$realizeDate,$returnDate,$reintegrationActivityCompleted,
			$AGBLanguage,$AGBVersion,$isAGBUploaded,$dateAGBSigned,	$AGBStatus,
			$signedStudentContract,
			$isANUploaded,$dateANUploaded,
			
			$isEnrollmentCertificateUploaded,
			$dateEnrollmentCertificateUploaded,
			$dateExperienceReportUploaded,
			
			$isDisplayedInPortal,$isEditableInPortal,
			
			$amountICCFee,$amountInpayment,$amountMatchingFee,
			$amountPEDSFee,$amountRaisingFee,$amountRefunding,
			$amountRetention
	){
		$this->sId = $sId;
		$this->GIPGCDP = $GIPGCDP;
		$this->aiesecEpId = $aiesecEpId;
		$this->tnId = $tnId;
		
		$this->earliestStartDate = $this->formatToDateTime($earliestStartDate);
		$this->latestEndDate = $this->formatToDateTime($latestEndDate);
		$this->minimumDuration = $minimumDuration;
		$this->maximumDuration = $maximumDuration;
		$this->epStatus = $epStatus;
		$this->realizeDate = $this->formatToDateTime($realizeDate);
		$this->returnDate = $this->formatToDateTime($returnDate);
		$this->reintegrationActivityCompleted = $reintegrationActivityCompleted;
		
		$this->AGBLanguage = $AGBLanguage;
		$this->AGBVersion = $AGBVersion;
		$this->isAGBUploaded = $isAGBUploaded;
		$this->dateAGBSigned = $this->formatToDateTime($dateAGBSigned);
		$this->AGBStatus = $AGBStatus;
		
		$this->isEnrollmentCertificateUploaded = $isEnrollmentCertificateUploaded;
		$this->dateEnrollmentCertificateUploaded =
			$this->formatToDateTime($dateEnrollmentCertificateUploaded);
		
		$this->signedStudentContract = $signedStudentContract;
		$this->isANUploaded = $isANUploaded;
		$this->dateANUploaded = $this->formatToDateTime($dateANUploaded);
		
		$this->dateExperienceReportUploaded = 
			$this->formatToDateTime($dateExperienceReportUploaded);
		
		$this->amountICCFee = $amountICCFee;
		$this->amountInpayment = $amountInpayment;
		$this->amountMatchingFee = $amountMatchingFee;
		$this->amountPEDSFee = $amountPEDSFee;
		$this->amountRaisingFee = $amountRaisingFee;
		$this->amountRefunding = $amountRefunding;
		$this->amountRetention = $amountRetention;
		
		$this->isDisplayedInPortal = $isDisplayedInPortal;
		$this->isEditableInPortal = $isEditableInPortal;
		
		$this->epStatusPreExchange = !(
				$epStatus === DBValues::$DB_VALUES_EP_STATUS["realized"] ||
				$epStatus === DBValues::$DB_VALUES_EP_STATUS["rejected"] ||
				$epStatus === DBValues::$DB_VALUES_EP_STATUS["expired"]
		);
		
		$this->stage = -1;
	}
	
	private function formatToDateTime($date){
		if(is_string($date))
			return new \DateTime($date);
		else if(is_object($date) && $date instanceof \DateTime)
			return $date;
		return null;
	}

	public function getId(){
		return $this->sId;
	}

	const GIPGCDP_GIP = "Global Talent";
	const GIPGCDP_GCDP = "Global Citizen";
	const GIPGCDP_GEP = "Global Exchange";
	public function getFocusOfInternship() {
		if($this->GIPGCDP == "Global Internship") return self::GIPGCDP_GIP;
		if($this->GIPGCDP == "Global Community Development Internship") return self::GIPGCDP_GCDP;
		return self::GIPGCDP_GEP;
	}
	
	public function getAiesecEpId(){return $this->aiesecEpId;}
	public function getTnId(){return $this->tnId;}
	public function getStage(){
		if($this->stage < 0){
			$AGBConfirmed = ($this->AGBStatus === DBValues::$DB_VALUES_AGB_STATUS["confirmed"]);
			$inPaymentLess75 = ($this->amountInpayment < 75.0);
			$epStatusRealized = ($this->epStatus === DBValues::$DB_VALUES_EP_STATUS["realized"]);
			$realizeDateTodayOrPast = (($this->realizeDate !== null) &&
					($this->realizeDate->getTimestamp()-time() <= 0));
			$returnDateInPast = (($this->returnDate !== null) &&
					($this->returnDate->getTimestamp()-time() < 0));
			
			$this->stage = 0;
			if(!$AGBConfirmed || $inPaymentLess75)
				$this->stage = self::STAGE_CONTRACT_PAYMENT;
			if($this->epStatusPreExchange && $AGBConfirmed && !$inPaymentLess75)
				$this->stage = self::STAGE_PRE_EXCHANGE;
			if(!$returnDateInPast && ($realizeDateTodayOrPast || $epStatusRealized))
				$this->stage = self::STAGE_EXCHANGE;
			if(!$this->reintegrationActivityCompleted && $returnDateInPast)
				$this->stage = self::STAGE_POST_EXCHANGE;
			if($this->reintegrationActivityCompleted && $returnDateInPast)
				$this->stage = self::STAGE_FINISHED;
		}
		
		return $this->stage;
	}

	public function getEarliestStartDate() {
		return $this->earliestStartDate;
	}

	public function setEarliestStartDate($earliestStartDate) {
		$this->earliestStartDate = $this->formatToDateTime($earliestStartDate);
	}

	public function getLatestEndDate() {
		return $this->latestEndDate;
	}

	public function setLatestEndDate($latestEndDate) {
		$this->latestEndDate = $this->formatToDateTime($latestEndDate);
	}

	public function getMinimumDuration() {
		return $this->minimumDuration;
	}

	public function setMinimumDuration($minimumDuration) {
		$this->minimumDuration = $minimumDuration;
	}
	public function getMinimumDurationIndexed(){
		return array_search($this->minimumDuration,$this->getMinimumDurationArray());
	}
	public function setMinimumDurationIndexed($index){
		$array = $this->getMinimumDurationArray();
		$this->minimumDuration = $array[$index];
	}
	public function getMinimumDurationArray(){
		$focus = $this->getFocusOfInternship();
		if($focus === self::GIPGCDP_GIP)
			return range(20,74);
		if($focus === self::GIPGCDP_GCDP)
			return range(6,16);
		else
			return range(6,74);
	}

	public function getMaximumDuration() {
		return $this->maximumDuration;
	}

	public function setMaximumDuration($maximumDuration) {
		$this->maximumDuration = $maximumDuration;
	}
	public function getMaximumDurationIndexed(){
		return array_search($this->maximumDuration,$this->getMaximumDurationArray());
	}
	public function setMaximumDurationIndexed($index){
		$array = $this->getMaximumDurationArray();
		$this->maximumDuration = $array[$index];
	}
	public function getMaximumDurationArray(){
		$focus = $this->getFocusOfInternship();
		if($focus === self::GIPGCDP_GIP)
			return range(20,74);
		if($focus === self::GIPGCDP_GCDP)
			return range(6,16);
		else
			return range(6,74);
	}
	
	public function isDurationValid(){
		$ret = 0;
		if(!in_array($this->minimumDuration,$this->getMinimumDurationArray()))
			$ret = 3;
		else if(!in_array($this->maximumDuration,$this->getMaximumDurationArray()))
			$ret = 2;
		else if($this->maximumDuration < $this->minimumDuration)
			$ret = 1;
	
		return $ret;
	}

// 	public function getAGBAccepted() {
// 		return $this->AGB_accepted__c;
// 	}
// 
// 	public function setAGBAccepted($agbAccepted) {
// 		$this->AGB_accepted__c = $agbAccepted;
// 	}

	public function getAGBFile(){return $this->AGBFile;}
	public function setAGBFile($file){$this->AGBFile = $file;}

	public function getAGBLanguage() {return $this->AGBLanguage;}
	public function setAGBLanguage($agbLanguage) {
		$this->AGBLanguage = $agbLanguage;
	}

	public function getAGBVersion() {return $this->AGBVersion;}
	public function setAGBVersion($agbVersion) {$this->AGBVersion = $agbVersion;}

	public function isSignedAGBasPDF() {return $this->isAGBUploaded;}
	public function setSignedAGBasPDF($signedAGBasPDF) {
		$this->isAGBUploaded = $signedAGBasPDF;
	}

	public function getDateAGBSigned() {return $this->dateAGBSigned;}
	public function setDateAGBSigned($dateAGBSigned) {
		$this->dateAGBSigned = $this->formatToDateTime($dateAGBSigned);
	}

	public function getAGBStatus() {return $this->AGBStatus;}
	public function setAGBStatus($agbStatus) {$this->AGBStatus = $agbStatus;}

	public function getStudentContractSigned() {
		return $this->signedStudentContract;
	}

	public function setANFile($file){$this->ANFile = $file;}
	public function getANFile(){return $this->ANFile;}
	
	public function getAcceptanceNoteUploaded() {
		return $this->isANUploaded;
	}
	public function setAcceptanceNoteUploaded($acceptanceNoteUpload) {
		$this->isANUploaded = $acceptanceNoteUpload;
	}

	public function getDateAcceptanceNoteUploaded() {
		return $this->dateANUploaded;
	}
	public function setDateAcceptanceNoteUploaded($dateAcceptanceNoteUploaded) {
		$this->dateANUploaded = $this->formatToDateTime($dateAcceptanceNoteUploaded);
	}

	public function isReadonly() {
		return $this->isEditableInPortal;
	}

	public function isDisplayedInPotal() {
		return $this->isDisplayedInPortal;
	}
	
	public function setCertificateOfEnrollment($file){
		$this->certificateOfEnrollment = $file;
	}
	public function getCertificateOfEnrollment(){
		return $this->certificateOfEnrollment;
	}
	public function getDateEnrollmentCertificateUpdated(){
		return $this->	dateEnrollmentCertificateUploaded;
	}
	public function isEnrollmentCertificateUploaded(){
		return $this->isEnrollmentCertificateUploaded;
	}
	
	public function getExperienceReport(){return $this->experienceReportFile;}
	public function setExperienceReport($file){$this->experienceReportFile = $file;}
	public function isExperienceReportUploaded(){return ($this->dateExperienceReportUploaded!==null);}
	public function getDateExperienceReportUploaded(){return $this->dateExperienceReportUploaded;}
	
	
	public function getAmountICCFee(){ return $this->amountICCFee;}
	public function getAmountInpayment(){ return $this->amountInpayment;}
	public function getAmountMatchingFee(){return $this->amountMatchingFee;}
	public function getAmountPEDSFee(){return $this->amountPEDSFee;}
	public function getAmountRaisingFee(){return $this->amountRaisingFee;}
	public function getAmountRefunding(){return $this->amountRefunding;}
	public function getAmountRetention(){return $this->amountRetention;}

	public function isEpStatusPreExchange(){
		return $this->epStatusPreExchange;
	}
}
?>
