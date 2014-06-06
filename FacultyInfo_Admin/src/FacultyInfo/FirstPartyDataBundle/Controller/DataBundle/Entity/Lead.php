<?php
namespace AIESEC\Portal\DataBundle\Entity;
use AIESEC\Portal\DataBundle\Service as Data;
use Symfony\Component\Validator\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Assert\Callback(methods={"validateDescriptionFields"})
 */
class Lead
{
	const MAX_WORDS = 10;
	const TYPE_GIP = "GIP";
	const TYPE_GCDP = "GCDP";

	public $leadType;

	//======= personal data =======
	/** @Assert\NotBlank() */
	public $firstName;
	/** @Assert\NotBlank() */
	public $lastName;
	/**
	 * @Assert\Choice(callback = "getGenders")
	 * @Assert\NotBlank()
	 */
	public $gender;
	/**
	 * @Assert\NotBlank()
	 * @Assert\Email()
	 */
	public $email;
	/**
	 * Phone is not a required information. Also it is not known
	 * how the applicant is entering the numer
	 * (e.g.: 030/1234 or (49)(30)1234 or ...).
	 * That is why there can be no validator for blankness or number
	 * 
	 * @Assert\Length(max="20")
	 */
	public $phone;
	/**
	 * @Assert\NotBlank()
	 * @Assert\Date()
	 */
	public $birthdate;

	//======= university =======
	/**
	 * @Assert\NotBlank()
	 * @Assert\Choice(callback="getYesNo")
	 */
	public $student;
	/**
	 * @Assert\NotBlank()
	 * @Assert\Choice(callback="getUniversities")
	 */
	public $university;
	/**
	 * @Assert\NotBlank()
	 * @Assert\Choice(callback="getAreasOfStudies")
	 */
	public $areaOfStudies;
	/**
	 * @Assert\NotBlank()
	 * @Assert\Range(min="1", max="99")
	 */
	public $semester;
	/**
	 * @Assert\NotBlank()
	 * @Assert\Choice(callback="getGraduationYears")
	 */
	public $graduationYear;
	/**
	 * @Assert\NotBlank()
	 * @Assert\Choice(callback="getDegreeTypes")
	 */
	public $degreeType;
	/**
	 * @Assert\Choice(callback="getLanguages",multiple=true)
	 */
	public $languagesNative,$languagesExcellent,$languagesGood;

	public $practicalExperience,$practicalExperienceDescription;


	/**
	 * Is/was the applicant involved in voluntary work
	 * in parallel to his studies
	 */
	public $voluntaryWork;
	/**
	 * In case $voluntaryWork is true,
	 * contains a description about what kind of work is/was done.
	 */
	public $voluntaryWorkDescription;


	//============ Internship =============
	public $focus;
	public $earliestStartDate,$latestStartDate;
	public $minDuration,$maxDuration;
	public $worldAreasOfInterest,$countriesOfInterest;
	public $letterOfMotivation;

	//============ Global Talent =============
	/**
	* Which course is the applicant studying and
	* what is his specialization.
	*/
	public $courseOfStudies;
	public $focusForIt;
	public $itSkills;
	public $flexibilityFocusOfInternshipAndCountry;
	public $inAiesec;
	//========== End Internship ===========

	/** How did the applicant got to know about AIESEC */
	public $wayOfFindingAiesec;

	public $additionalComments;

	public $cv;


	public static function getDurationArrayGIP(){
		return array_combine(range(20,74),range(20,74));
	}

	public static function getDurationArrayGCDP(){
		return array_combine(range(6,16),range(6,16));
	}

	function __construct($type){
		$this->type = $type;
	}

	//============== Validation ================
	/** For some reason the validator is not working properly,
	 * when directly calling callback in DBValues */
	public static function getGenders(){return Data\DBValues::getGenders();}
	public static function getYesNo(){return Data\DBValues::getValuesYesNo();}
	public static function getUniversities(){return Data\DBValues::getUniversities();}
	public static function getAreasOfStudies(){
		return array_keys(Data\DataServiceLeads::$DB_VALUES_AREA_OF_STUDIES);
	}
	public static function getGraduationYears(){return Data\DBValues::getGraduationYears();}
	public static function getDegreeTypes(){return Data\DBValues::getDegreeTypes();}
	public static function getLanguages(){return Data\DBValues::getLanguages();}

	public function validateDescriptionFields(ExecutionContextInterface $context)
	{
		//check practical experience descprition
		if($this->practicalExperience === 'yes'){
			$words = str_word_count($this->practicalExperienceDescription);
			if($words < 5){
				$context->addViolationAt(
						'practicalExperienceDescription',
						'lead.moreInformationAboutExperience',
						array('translation_domain' => 'validators'),
						null
				);
			}else if($words > self::MAX_WORDS){//TODO: change to 500
				$context->addViolationAt(
						'practicalExperienceDescription',
						'lead.lessInformationAboutExperience',
						array('translation_domain' => 'validators','%maxWords%' => self::MAX_WORDS),
						null
				);
			}
		}
		if($this->voluntaryWork === 'yes'){
			$words = str_word_count($this->voluntaryWorkDescription);
			if($words < 5){
				$context->addViolationAt(
						'voluntaryWorkDescription',
						'lead.moreInformationAboutExperience',
						array('translation_domain' => 'validators'),
						null
				);
			}else if($words > self::MAX_WORDS){//TODO: change to 500
				$context->addViolationAt(
						'voluntaryWorkDescription',
						'lead.lessInformationAboutExperience',
						array('translation_domain' => 'validators','%maxWords%' => self::MAX_WORDS),
						null
				);
			}
		}
	}

}