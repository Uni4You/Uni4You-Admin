<?php
namespace AIESEC\Portal\DataBundle\Entity;
use AIESEC\Portal\DataBundle\Service;
use Symfony\Component\Validator\Constraints\IbanValidator;

class Account
{
	// extracted data from backend
	private $sID;

	private $ownerId;

	private $ownerName;

	private $firstName;

	private $lastName;

	private $gender;

	private $email;

	private $phone;

	/**
	 * variable holds date in DateTime format
	 */
	private $birthDate;

	private $birthPlace;

	private $university;

	private $areaOfStudies;

	private $semester;

	private $graduationYear;

	private $isStudent;

	private $degreeType;

	private $address;

	private $zip;

	private $city;

	private $languageLevelExcellent;

	private $languageLevelGood;

	private $languageLevelNative;

	private $languageCertificate, $languageCertificate2, $languageCertificate3;

	private $cv;

	private $cvDateUploaded;

	private $cvUploaded;

	private $icc;

	private $iccNecessary;

	private $password;

	private $isPortalPasswordResetNeeded;

	private $passwordResetHash;

	private $passwordResetHashDate;

	private $bankName;

	private $bankAccountOwner;

	private $bic;

	private $iban;
	
	// EP Objects connected to this
	private $eps;

	/**
	 * if the account is/was a member of AIESEC this object
	 * will hold all necessary information.
	 * Null otherwise.
	 */
	private $membership;

	/**
	 * Array of all timeslots offered by the account or false if shallow query
	 */
	private $timeslotsOffered;

	/**
	 * Array of all timeslots booked by the account or false if shallow query
	 */
	private $timeslotsBooked;
	
	// function __construct ($sID, $ownerId, $ownerName, $firstName, $lastName,
	// $email, $gender, $phone,
	// $birthDate, $birthPlace, $university, $areaOfStudies, $semester,
	// $graduationYear,
	// $isStudent, $degreeType, $address, $zip, $city, $languageLevelExcellent,
	// $languageLevelGood, $languageLevelNative, $cvDateUploaded,
	// $cvUploaded, $icc, $iccNecessary,
	
	// $password, $isPortalPasswordResetNeeded, $passwordResetHash,
	// $passwordResetHashDate,
	
	// $eps,$membership,$timeslotsOffered, $timeslotsBooked,
	
	// $bankName, $bankAccountOwner, $bic, $iban)
	// {
	// $this->sID = $sID;
	// $this->ownerId = $ownerId;
	// $this->ownerName = $ownerName;
	
	// $this->firstName = $firstName;
	// $this->lastName = $lastName;
	// $this->email = $email;
	
	// $this->gender = $gender;
	// $this->phone = $phone;
	// $this->setBirthday($birthDate);
	// $this->setBirthPlace($birthPlace);
	// $this->university = $university;
	// $this->areaOfStudies = $areaOfStudies;
	// $this->semester = $semester;
	// $this->graduationYear = $graduationYear;
	// $this->isStudent = $isStudent;
	// $this->degreeType = $degreeType;
	// $this->address = $address;
	// $this->zip = $zip;
	// $this->city = $city;
	// $this->languageLevelExcellent = $languageLevelExcellent;
	// $this->languageLevelGood = $languageLevelGood;
	// $this->languageLevelNative = $languageLevelNative;
	// $this->setCVDate($cvDateUploaded);
	// $this->cvUploaded = $cvUploaded;
	// $this->icc = $icc;
	// $this->iccNecessary = $iccNecessary;
	
	// $this->password = $password;
	// $this->isPortalPasswordResetNeeded = $isPortalPasswordResetNeeded;
	// $this->passwordResetHash = $passwordResetHash;
	// $this->passwordResetHashDate =
	// $this->formatToDateTime($passwordResetHashDate);
	
	// $this->eps = $eps;
	// $this->membership = $membership;
	
	// $this->timeslotsOffered = (is_null($timeslotsOffered)?
	// false:$timeslotsOffered);
	// $this->timeslotsBooked = (is_null($timeslotsBooked)?
	// false:$timeslotsBooked);
	
	// $this->bankName = $bankName;
	// $this->bankAccountOwner = $bankAccountOwner;
	// $this->bic = $bic;
	// $this->iban = $iban;
	// }
	private function formatToDateTime ($date)
	{
		if (is_string($date))
			return new \DateTime($date);
		else 
			if (is_object($date) && $date instanceof \DateTime)
				return $date;
		return null;
	}

	public function setId ($id)
	{
		$this->sID = $id;
	}

	public function getId ()
	{
		return $this->sID;
	}

	public function setOwnerId ($id)
	{
		$this->ownerId = $id;
	}

	public function getOwnerId ()
	{
		return $this->ownerId;
	}

	public function setOwnerName ($name)
	{
		$this->ownerName = $name;
	}

	public function getOwnerName ()
	{
		return $this->ownerName;
	}

	public function getName ()
	{
		return $this->firstName . ' ' . $this->lastName;
	}

	public function setFirstName ($firstName)
	{
		$this->firstName = $firstName;
	}

	public function getFirstName ()
	{
		return $this->firstName;
	}

	public function setLastName ($lastName)
	{
		$this->lastName = $lastName;
	}

	public function getLastName ()
	{
		return $this->lastName;
	}

	public function getGender ()
	{
		return $this->gender;
	}

	public function setGender ($gender)
	{
		$this->gender = $gender;
	}

	public function setEmail ($email)
	{
		$this->email = $email;
	}

	public function getEmail ()
	{
		return $this->email;
	}

	public function getPhone ()
	{
		return $this->phone;
	}

	public function setPhone ($phone)
	{
		$this->phone = $phone;
	}

	/**
	 *
	 * @return : birthday as instance of DateTime
	 */
	public function getBirthday ()
	{
		return $this->birthDate;
	}

	/**
	 * Function sets account's birthday to $birthday.
	 * $birthday can be one of the following 3 types
	 * -null: internal variable is set to null
	 * -string containing date: internal variable is
	 * set to DateTime object constructed by $birthday
	 * -instance of DateTime: internal variable is set
	 * to passed-in instance
	 */
	public function setBirthday ($birthday)
	{
		$this->birthDate = $this->formatToDateTime($birthday);
	}

	public function setBirthPlace ($birthPlace)
	{
		$this->birthPlace = $birthPlace;
	}

	public function getBirthPlace ()
	{
		return $this->birthPlace;
	}

	public function getUniversity ()
	{
		return $this->university;
	}

	public function setUniversity ($university)
	{
		$this->university = $university;
	}

	public function getAreaOfStudies ()
	{
		return $this->areaOfStudies;
	}

	public function setAreaOfStudies ($areaOfStudies)
	{
		$this->areaOfStudies = $areaOfStudies;
	}

	public function getSemester ()
	{
		return $this->semester;
	}

	public function setSemester ($semester)
	{
		$this->semester = $semester;
	}

	public function getGraduationYear ()
	{
		return $this->graduationYear;
	}

	public function setGraduationYear ($graduationYear)
	{
		$this->graduationYear = $graduationYear;
	}

	public function isStudent ()
	{
		return $this->isStudent;
	}

	public function setStudent ($student)
	{
		$this->isStudent = $student;
	}

	public function getDegreeType ()
	{
		return $this->degreeType;
	}

	public function setDegreeType ($degreeType)
	{
		$this->degreeType = $degreeType;
	}

	public function getAddress ()
	{
		return $this->address;
	}

	public function setAddress ($address)
	{
		$this->address = $address;
	}

	public function getZIP ()
	{
		return $this->zip;
	}

	public function setZIP ($zip)
	{
		$this->zip = $zip;
	}

	public function getCity ()
	{
		return $this->city;
	}

	public function setCity ($city)
	{
		$this->city = $city;
	}

	public function getLanguagesExcellent ()
	{
		return $this->languageLevelExcellent;
	}

	public function setLanguagesExcellent ($languagesExcellent)
	{
		$this->languageLevelExcellent = $languagesExcellent;
	}

	public function getLanguagesGood ()
	{
		return $this->languageLevelGood;
	}

	public function setLanguagesGood ($languagesGood)
	{
		$this->languageLevelGood = $languagesGood;
	}

	public function getLanguagesNative ()
	{
		return $this->languageLevelNative;
	}

	public function setLanguagesNative ($languagesNative)
	{
		$this->languageLevelNative = $languagesNative;
	}

	public function setLanguageCertificate ($file)
	{
		$this->languageCertificate = $file;
	}

	public function getLanguageCertificate ()
	{
		return $this->languageCertificate;
	}

	public function setLanguageCertificate2 ($file)
	{
		$this->languageCertificate2 = $file;
	}

	public function getLanguageCertificate2 ()
	{
		return $this->languageCertificate2;
	}

	public function setLanguageCertificate3 ($file)
	{
		$this->languageCertificate3 = $file;
	}

	public function getLanguageCertificate3 ()
	{
		return $this->languageCertificate3;
	}

	public function getLanguageCertificates ()
	{
		return array_filter(array(
				$this->languageCertificate,
				$this->languageCertificate2,
				$this->languageCertificate3
		), create_function('$field', 'return !($field===NULL);'));
	}

	public function getICLS ()
	{
		return $this->icc;
	}

	public function setICLS ($icls)
	{
		$this->icc = $icls;
	}

	public function setICLSNecessary ($necessary)
	{
		$this->iccNecessary = $necessary;
	}

	public function getICLSNecessary ()
	{
		return $this->iccNecessary;
	}

	public function getCv ()
	{
		return $this->cv;
	}

	public function setCv ($cv)
	{
		$this->cv = $cv;
	}

	public function getCVDate ()
	{
		return $this->cvDateUploaded;
	}

	public function setCVDate ($cvDate)
	{
		$this->cvDateUploaded = $this->formatToDateTime($cvDate);
	}

	public function isCVUploaded ()
	{
		return $this->cvUploaded;
	}

	public function setCVUploaded ($cvUploaded)
	{
		$this->cvUploaded = $cvUploaded;
	}

	public function getPassword ()
	{
		return $this->password;
	}

	public function setPassword ($password)
	{
		$this->password = $password;
	}

	public function isPortalPasswordResetNeeded ()
	{
		return $this->isPortalPasswordResetNeeded;
	}

	public function setPortalPasswordResetNeeded ($isPortalPasswordResetNeeded)
	{
		$this->isPortalPasswordResetNeeded = $isPortalPasswordResetNeeded;
	}

	public function setEPs ($eps)
	{
		$this->eps = $eps;
	}

	public function getEPs ()
	{
		return $this->eps;
	}

	public function getEP ($epId)
	{
		return $this->eps[$epId];
	}

	public function setIban ($iban)
	{
		$this->iban = $iban;
	}

	public function getIban ()
	{
		return $this->iban;
	}

	public function setBic ($bic)
	{
		$this->bic = $bic;
	}

	public function getBic ()
	{
		return $this->bic;
	}

	public function setBankAccountOwner ($owner)
	{
		$this->bankAccountOwner = $owner;
	}

	public function getBankAccountOwner ()
	{
		return $this->bankAccountOwner;
	}

	public function setBankName ($name)
	{
		$this->bankName = $name;
	}

	public function getBankName ()
	{
		return $this->bankName;
	}

	public function setPasswordResetHash ($hash)
	{
		$this->passwordResetHash = $hash;
	}

	public function setPasswordResetHashDate ($date)
	{
		$this->passwordResetHashDate = self::formatToDateTime($date);
	}

	public function isPasswordResetHashValid ($hash)
	{
		if ($this->passwordResetHashDate == null)
			return 1;
		if (0 > ($this->passwordResetHashDate->getTimestamp() - strtotime('-24 hours')))
			return 1;
		if ($hash !== $this->passwordResetHash)
			return 2;
		
		return 0;
	}

	/**
	 * only set membership if null (delete membership) or a
	 * valid object is passed.
	 *
	 * @var Membership $membership
	 */
	public function setMembership ($membership)
	{
		if ($membership === null || $membership instanceof Membership) {
			$this->membership = $membership;
		}
	}

	/**
	 * Function returns membership object of the account in
	 * case it represents a member.
	 * Null otherwise.
	 */
	public function getMembership ()
	{
		return $this->membership;
	}

	/**
	 * Returns true if Account represents an active AIESEC member.
	 * If false is returned the account can still present an
	 * alumni member!
	 *
	 * @return boolean true if account is active member.
	 */
	public function isMember ()
	{
		return ($this->membership !== null && $this->membership->getMemberType() === Membership::MEMBER_TYPE_ACTIVE);
	}

	/**
	 *
	 * @return boolean true if account is inactive member (alumni).
	 */
	public function isAlumni ()
	{
		return ($this->membership !== null && $this->membership->getMemberType() === Membership::MEMBER_TYPE_ALUMNI);
	}

	public function setTimeslotsOffered ($timeslots)
	{
		if (is_array($timeslots))
			$this->timeslotsOffered = $timeslots;
	}

	public function getTimeslotsOffered ()
	{
		return $this->timeslotsOffered;
	}

	public function getOpenTimeslotsOffered ()
	{
		$timeslots = array();
		foreach ($this->timeslotsOffered as $timeslot) {
			if ($timeslot->isAvailable()) {
				$timeslots[] = $timeslot;
			}
		}
		return $timeslots;
	}

	public function getClosedTimeslotsOffered ()
	{
		$timeslots = array();
		foreach ($this->timeslotsOffered as $timeslot) {
			if (! $timeslot->isAvailable()) {
				$timeslots[] = $timeslot;
			}
		}
		return $timeslots;
	}

	public function setTimeslotsBooked ($timeslots)
	{
		if (is_array($timeslots))
			$this->timeslotsBooked = $timeslots;
	}

	public function getTimeslotsBooked ()
	{
		return $this->timeslotsBooked;
	}
}
?>
