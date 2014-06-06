<?php
namespace AIESEC\Portal\DataBundle\Service;
use AIESEC\Portal\DataBundle\Entity\Account;
use AIESEC\Portal\DataBundle\Entity\EP;
use AIESEC\Portal\DataBundle\Entity\Membership;
use Doctrine\DBAL\Driver\IBMDB2\DB2Connection;
class DataServiceAccount
{
	public static function sObjectToAccountWrapper($accountSObject, $flags = 0)
	{
		$sObject = new \SObject($accountSObject);

 		$fields = (array)($sObject->fields);
 		
 		$account = new Account();
		$sId = $sObject->Id;
 		
		$account->setId($sId);
		$account->setOwnerId($fields[DBConstants::DB_OWNER_ID]);
		$account->setOwnerName($fields[DBConstants::DB_OWNER_NAME]);
		
 		$account->setFirstName($fields[DBConstants::DB_FIRST_NAME]);
 		$account->setLastName($fields[DBConstants::DB_LAST_NAME]);
 		
 		$gender = array_search($fields[DBConstants::DB_GENDER],DBValues::$DB_VALUES_GENDER);
 		if($gender === false) $gender = null;
 		$account->setGender($gender);
 		
 		$account->setEmail($fields[DBConstants::DB_PERSON_EMAIL]);
 		$account->setPhone($fields[DBConstants::DB_PHONE]);
 		$account->setBirthday($fields[DBConstants::DB_BIRTH_DATE]);
 		$account->setBirthPlace($fields[DBConstants::DB_BIRTH_PLACE]);
 		
 		$university = array_search($fields[DBConstants::DB_UNIVERSITY],DBValues::$DB_VALUES_UNIVERSITY);
 		if($university === false) $university = null;
 		$account->setUniversity($university);
 		
 		$areasOfStudies = array_search($fields[DBConstants::DB_AREA_OF_STUDIES],DBValues::$DB_VALUES_AREA_OF_STUDIES);
 		if($areasOfStudies === false) $areasOfStudies = null;
 		$account->setAreaOfStudies($areasOfStudies);
 		
 		$account->setSemester($fields[DBConstants::DB_SEMESTER]);
 		$graduationYear = array_search($fields[DBConstants::DB_GRADUATION_YEAR],DBValues::$DB_VALUES_GRADUATION_YEAR);
 		if($graduationYear === false) $graduationYear = null;
 		$account->setGraduationYear($graduationYear);
 		$student = array_search($fields[DBConstants::DB_STUDENT],DBValues::$DB_VALUES_STUDENT);
 		if($student === false) $student = null;
 		$account->setStudent($student);
 		$degreeType = array_search($fields[DBConstants::DB_DEGREE_TYPE],DBValues::$DB_VALUES_DEGREE_TYPE);
 		if($degreeType === false) $degreeType = null;
 		$account->setDegreeType($degreeType);
 		
 		$account->setAddress($fields[DBConstants::DB_ADDRESS]);
 		$account->setZIP($fields[DBConstants::DB_ZIP]);
 		$account->setCity($fields[DBConstants::DB_CITY]);
 		
 		$account->setLanguagesExcellent(explode(";",$fields[DBConstants::DB_LANGUAGE_LEVEL_EXCELLENT]));
 		$account->setLanguagesGood(explode(";",$fields[DBConstants::DB_LANGUAGE_LEVEL_GOOD]));
 		$account->setLanguagesNative(explode(";",$fields[DBConstants::DB_LANGUAGE_LEVEL_NATIVE]));
 		
 		$account->setCVDate($sObject->fields->CV_Date__c);
 		$account->setCVUploaded($sObject->fields->CV_Uploaded__c == DBConstants::SF_TRUE);
 		
 		$account->setICLS($fields[DBConstants::DB_ICC]);
 		$iccNecessary = array_search($fields[DBConstants::DB_ICC_NECESSARY], DBValues::$DB_VALUES_ICLS_NECESSARY);
 		if($iccNecessary === false) $iccNecessary = null;
 		$account->setICLSNecessary($iccNecessary);
 		
 		$account->setPassword($fields[DBConstants::DB_PASSWORD]);
 		$account->setPortalPasswordResetNeeded($fields[DBConstants::DB_PASSWORD_RESET_NEEDED] == DBConstants::SF_TRUE);
 		$account->setPasswordResetHash($fields[DBConstants::DB_PASSWORD_RESET_HASH]);
 		$account->setPasswordResetHashDate($fields[DBConstants::DB_PASSWORD_RESET_HASH_DATE]);
 		
 		$account->setBankName($fields[DBConstants::DB_BANK_NAME]);
 		$account->setBankAccountOwner($fields[DBConstants::DB_BANK_ACCOUNT_OWNER]);
 		$account->setBic($fields[DBConstants::DB_BIC]);
 		$account->setIban($fields[DBConstants::DB_IBAN]);
		
		//=============== get EPs =================
		$eps = array();
		if(isset($accountSObject->queryResult))
		{			
			foreach ($accountSObject->queryResult as $subQueryResult) {
				foreach ($subQueryResult->records as $subRecord) {
					$subquerySObject = new \SObject($subRecord);
					if($subRecord->type === DBConstants::TYPE_EP){
						// record describes an EP
						if ($subquerySObject->fields->isDisplayedInPortal__c == 'true') {
							$ep = DataServiceEP::sObjectToEPWrapper($subquerySObject);
							$eps[$subquerySObject->Id] = $ep;
						}
					}
					/*
					 * case type == TYPE_JOB is handled by wrapper function in
					 * DataServiceMembership class. On the downside there is
					 * code overhead since the loops are running twice!
					 */
				}
			}
		}
		
		//=============== end get EPs =================
		
		//====== create Membership if necessary =======
		/* conversion to array to push field name dependency to 
		 * one location only (DBConstants..). Following the internet
		 * not usable for accessing integer values and some other
		 * cases (http://stackoverflow.com/questions/4345554/
		 * convert-php-object-to-associative-array).
		 * TODO: if working, update access for all fields */
		
		if(DBConstants::SF_TRUE ===
			$fields[DBConstantsMembership::DB_MEMBERSHIP_IS_WAS_MEMBER]){
			//only create membership object if account has membership flag
			
			$membership = MembershipService::sObjectToMembershipWrapper($accountSObject, $flags);
		}else{
			$membership = null;
		}
		
		$timeslotsOffered = null;
		$timeslotsBooked = null;
		if(($flags & DataService::FLAG_TIMESLOTS) != 0){
			$timeslotsOffered = array();
			$timeslotsBooked = array();
			if(isset($accountSObject->queryResult)){
				foreach ($accountSObject->queryResult as $subQueryResult) {
					foreach ($subQueryResult->records as $subRecord) {
						$subquerySObject = new \SObject($subRecord);
						if ($subRecord->type === DBConstantsTimeslot::TYPE_TIMESLOT){
							$timeslot = TimeslotService::sObjectToTimeslotWrapper($subquerySObject);
							
							if($timeslot->getAccount() === $sId){
								$timeslotsOffered[] = $timeslot;
							}else{
								$timeslotsBooked[] = $timeslot;
							}
						}
					}
				}
			}
		}
		//========== end Membership creation===========
		
 		$account->setEPs($eps);
 		$account->setMembership($membership);
 		$account->setTimeslotsBooked($timeslotsBooked);
 		$account->setTimeslotsOffered($timeslotsOffered);

		return $account;
	}

	public static function getAccount ($key, $value, $sfConnection, $flags = 0)
	{
		if($key == null || trim($key) === "" || $value == null || trim($value) === "") {
			return null;
		}

		$query = "SELECT ";
		
		//attach fields of account
		$query .= implode(", ",DBConstants::$QUERY_FIELDS_ACCOUNT);
		
		//attach subquery for all connected EPs
		$query .= ", (SELECT ".implode(", ",DBConstants::$QUERY_FIELDS_EP).
		" from ".DBConstants::TABLE_NAME_EP.
		" order by ".DBConstants::DB_EARLIEST_START_DATE.
		")";
		
		if(($flags & DataService::FLAG_JOBS) != 0){
			//attach subquery for all connected career steps aka jobs (if member)
			$query .= ", (SELECT ".implode(", ",DBConstantsMembership::$QUERY_FIELDS_JOB);
			
			/*
			 * IMPORTANT: Cannot do a query in 2nd level of the root
			 * object (account). Conferences as well as Goals have to
			 * be loaded separately!
			 */
// 			if(($flags & DataService::FLAG_CONFERENCES) != 0){
// 				//TODO: load conference information (ommitted for now)
// 			}
			
// 			if(($flags & DataService::FLAG_GOAL) != 0){
// 				$query .= ", (SELECT ".implode(", ",DBConstantsGoal::$QUERY_FIELDS_GOAL);
						
// 				$query .= " from ".DBConstantsGoal::CHILD_RELATIONSHIP_NAME.
// 				" order by ".DBConstantsGoal::DB_GOAL_PERCENTAGE.
// 				")";
// 			}
			
			$query .= " from ".DBConstantsMembership::TABLE_NAME_JOB.
			" order by ".DBConstantsMembership::DB_JOB_DATE_STARTED.
			")";
		}
		
		if(($flags & DataService::FLAG_TIMESLOTS) != 0){
			// load all offered timeslots -> load information about booking person
			$query .= ", (SELECT ".implode(", ",DBConstantsTimeslot::$QUERY_FIELDS_TIMESLOT);
			// load booking person's info
			$query .= ", ".DBConstantsTimeslot::BOOKED_BY_RELATION.".Name".
						", ".DBConstantsTimeslot::BOOKED_BY_RELATION.".".DBConstants::DB_SKYPE_ID.
						", ".DBConstantsTimeslot::BOOKED_BY_RELATION.".".DBConstants::DB_PHONE.
						", ".DBConstantsTimeslot::BOOKED_BY_RELATION.".".DBConstants::DB_PERSON_EMAIL;
			$query .= " from ".DBConstantsTimeslot::CHILD_RELATION_TIMESLOT_OFFERED.
			//" order by ".DBConstantsTimeslot::.
			")";
			
			// load all booked timeslots -> load information about timeslot owner
			$query .= ", (SELECT ".implode(", ",DBConstantsTimeslot::$QUERY_FIELDS_TIMESLOT);
			// get parent information
			$query .= ", ".DBConstantsTimeslot::MASTER_DETAIL_RELATIONSHIP.".Name".
						", ".DBConstantsTimeslot::MASTER_DETAIL_RELATIONSHIP.".".DBConstants::DB_SKYPE_ID.
						", ".DBConstantsTimeslot::MASTER_DETAIL_RELATIONSHIP.".".DBConstants::DB_PHONE.
						", ".DBConstantsTimeslot::MASTER_DETAIL_RELATIONSHIP.".".DBConstants::DB_PERSON_EMAIL;
				
			$query .= " from ".DBConstantsTimeslot::CHILD_RELATION_TIMESLOT_BOOKED.
			")";
			
			// load all bookable timeslots (only those of teamleader for currently active jobs
			
		}
		
		//append missing query parts for base query on account object
		$query .= " from ".DBConstants::TABLE_NAME_ACCOUNT." a where $key = '$value'";

		$queryResult = $sfConnection->query($query);
		$records = $queryResult->records;
		
		if(count($records) == 0) {
			return null;
		}
		foreach ($records as $record) {
			$accountSObject = new \SObject($record);
			break;
		}

		$account = DataServiceAccount::sObjectToAccountWrapper($accountSObject, $flags);

		return $account;
	}

//====================== writing to database ========================
	public static function updateBankDataFromObject($account, $sfConnection){
		$fields = array(
			DBConstants::DB_BANK_NAME => $account->getBankName(),
			DBConstants::DB_BANK_ACCOUNT_OWNER => $account->getBankAccountOwner(),
			DBConstants::DB_BIC => $account->getBic(),
			DBConstants::DB_IBAN => $account->getIban(),
		);
		return DataServiceAccount::updateAccount($account->getId(),$fields,$sfConnection);
	}

	public static function updateAccountFromObject(Account $account, $sfConnection){
		$fields = array(
			//DBConstants::DB_ACCOUNT_ID=>$account->getId(), //database intern, should not be changable
			DBConstants::DB_FIRST_NAME=>$account->getFirstName(), //poses as key for many LCs
			DBConstants::DB_LAST_NAME=>$account->getLastName(), //see DB_FIRST_NAME
			DBConstants::DB_GENDER
				=>isset(DBValues::$DB_VALUES_GENDER[$account->getGender()])? DBValues::$DB_VALUES_GENDER[$account->getGender()]:null,
			DBConstants::DB_PERSON_EMAIL=>$account->getEmail(), //is used to identify acc in salesforce
			DBConstants::DB_PHONE=>$account->getPhone(),
			DBConstants::DB_BIRTH_DATE=>$account->getBirthday(),
			DBConstants::DB_UNIVERSITY
				=>isset(DBValues::$DB_VALUES_UNIVERSITY[$account->getUniversity()])? DBValues::$DB_VALUES_UNIVERSITY[$account->getUniversity()]:null,
			DBConstants::DB_AREA_OF_STUDIES
				=>isset(DBValues::$DB_VALUES_AREA_OF_STUDIES[$account->getAreaOfStudies()])? DBValues::$DB_VALUES_AREA_OF_STUDIES[$account->getAreaOfStudies()]:null,
			DBConstants::DB_SEMESTER=>$account->getSemester(),
			DBConstants::DB_GRADUATION_YEAR
				=>isset(DBValues::$DB_VALUES_GRADUATION_YEAR[$account->getGraduationYear()])? DBValues::$DB_VALUES_GRADUATION_YEAR[$account->getGraduationYear()]:null,
			DBConstants::DB_STUDENT
				=>isset(DBValues::$DB_VALUES_STUDENT[$account->isStudent()])? DBValues::$DB_VALUES_STUDENT[$account->isStudent()]:null,
			DBConstants::DB_DEGREE_TYPE
				=>isset(DBValues::$DB_VALUES_DEGREE_TYPE[$account->getDegreeType()])? DBValues::$DB_VALUES_DEGREE_TYPE[$account->getDegreeType()]:null,
			DBConstants::DB_ADDRESS=>$account->getAddress(),
			DBConstants::DB_ZIP=>$account->getZIP(),
			DBConstants::DB_CITY=>$account->getCity(),
			DBConstants::DB_LANGUAGE_LEVEL_EXCELLENT=>$account->getLanguagesExcellent(),
			DBConstants::DB_LANGUAGE_LEVEL_GOOD=>$account->getLanguagesGood(),
			DBConstants::DB_LANGUAGE_LEVEL_NATIVE=>$account->getLanguagesNative(),
			//DBConstants::DB_CV_DATE=>$account->getCVDate(),// will be set in case attachment is uploaded
			//DBConstants::DB_CV_UPLOADED=>$account->getCVUploaded(),// see ^
			DBConstants::DB_ICC=>$account->getICLS(),
			//DBConstants::DB_ICC_NECESSARY=>DBValues::$DB_VALUES_ICLS_NECESSARY[$account->getICLSNecessary()], //has no setter anyway
			DBConstants::DB_PASSWORD=>$account->getPassword(),
			DBConstants::DB_PASSWORD_RESET_NEEDED=>$account->isPortalPasswordResetNeeded(),
		);
		
		//delete all fields not allowed to be changed
		$fields = array_intersect_key($fields, array_flip(DBConstants::$modifyableFieldsAccount));
		//implode multible choice fields and set date types to format salesforce understands
		$fields = array_map(array('AIESEC\Portal\DataBundle\Service\DataService','databaseFieldsMapper'),$fields);
		//remove null fields
		$fields = array_filter($fields, create_function('$field','return !($field===NULL);'));
		
		//clear multi-select list if necessarry
		$fieldsToNull = array();
		if(!isset($fields[DBConstants::DB_LANGUAGE_LEVEL_EXCELLENT]))
			$fieldsToNull[] = DBConstants::DB_LANGUAGE_LEVEL_EXCELLENT;
		if(!isset($fields[DBConstants::DB_LANGUAGE_LEVEL_GOOD]))
			$fieldsToNull[] = DBConstants::DB_LANGUAGE_LEVEL_GOOD;
		if(!isset($fields[DBConstants::DB_LANGUAGE_LEVEL_NATIVE]))
			$fieldsToNull[] = DBConstants::DB_LANGUAGE_LEVEL_NATIVE;

		$languageCertificates = $account->getLanguageCertificates();
		if(count($languageCertificates) > 0){
			$objects = array();
			foreach($languageCertificates as $languageCertificate){
				$file_size = filesize($languageCertificate);
				if($file_size > DBConstants::MAX_FILESIZE){
					return DataService::FILE_TOO_BIG;
				}else{
					//mimeType should be checked by symfony beforehand
					$handle = fopen($languageCertificate, "r");
					$content = fread($handle, $file_size);
					fclose($handle);

					//create sObject
					$sObject = new \sObject();
					$sObject->type = 'Attachment';
					$attachmentFields = array();
					$attachmentFields['parentId'] = $account->getId();
					$attachmentFields['name'] = $languageCertificate->getClientOriginalName();
					$attachmentFields['Description'] = DBValues::ATTACHMENT_DESCRIPTION_LANGUAGE_CERTIFICATE;
					$encoded = chunk_split(base64_encode($content));
					$attachmentFields['body'] = $encoded;
					$sObject->fields = $attachmentFields;

					$objects[] = $sObject;
				}
			}
			
			//upload attachments to salesforce
			$result = $sfConnection->create($objects);
			
			foreach($result as $res){
				if(!$res->success)
					return DataService::COULD_NOT_UPLOAD_ALL_LANGUAGE_CERTIFICATES;
			}
		}

		//upload cv when existing
		if(($cv = $account->getCV()) != null){
			$file_size = filesize($cv);
			if($file_size > DBConstants::MAX_FILESIZE){
				return DataService::FILE_TOO_BIG;
			}else{
				//mimeType should be checked by symfony beforehand
				$handle = fopen($cv, "r");
				$content = fread($handle, $file_size);
				fclose($handle);

				//create sObject
				$sObject = new \sObject();
				$sObject->type = 'Attachment';
				$attachmentFields = array();
				$attachmentFields['parentId'] = $account->getId();
				$attachmentFields['name'] = $cv->getClientOriginalName();
				$attachmentFields['Description'] = DBValues::ATTACHMENT_DESCRIPTION_CV;
				$encoded = chunk_split(base64_encode($content));
				$attachmentFields['body'] = $encoded;
				$sObject->fields = $attachmentFields;

				//upload attachment to salesforce
				$result = $sfConnection->create(array($sObject));
				if($result[0]->success == true) {
					// cv uploaded successfully, add information to salesforce account update
					$fields[DBConstants::DB_CV_UPLOADED] = true;
					$fields[DBConstants::DB_CV_DATE] = date('Y-m-d');
				}
			}
		}
		

		if($account->getMembership() != null){
			$membershipFields = MembershipService::
				getFieldsForUpdateFromMembership($account->getMembership());
			
			$fields = array_merge($fields, $membershipFields['fields']);
			$fieldsToNull = array_merge($fieldsToNull, $membershipFields['fieldsToNull']);
		}

			
		//do the actual database update
		// $fields will be tested for containing changable fields only even
		// though this functions already takes care of this!!!
		return DataServiceAccount::updateAccount($account->getId(),$fields,$sfConnection, $fieldsToNull);
	}

	/**
	 * This function updates the values in <code>$fields</code> of
	 * the Salesforce 'Account' object referenced by $sId.</p>
	 * All securrity checks have to be done before!
	 */
	public static function updateAccount($sId, $fields, $sfConnection, $fieldsToNull=null)
	{
		if(DataServiceAccount::validateAccountFields($fields))
		{
			$sObject = new \sObject();
			$sObject->type = DBConstants::TYPE_ACCOUNT;
			$sObject->Id = $sId;
			$sObject->fields = $fields;
			$sObject->fieldsToNull = $fieldsToNull;

			//TODO: catch exceptions
			$response = $sfConnection->update(array($sObject));
			return $response;
		}else{
			//TODO: error handling
			// write to log and set error fields
			return DataService::QUERY_CONTAINED_ILLEGAL_FIELDS;
		}
	}
	
	private static function validateAccountFields($fields)
	{
		$fieldsValid = true;

		// looks for the existing of every key in $fields
		// in the modifzableFieldsAccount array.
		// values behind keys should be validated when 
		// received in the forms
		foreach(array_keys($fields) as $field)
		{
			$fieldsValid &= !(FALSE === array_search($field,DBConstants::$modifyableFieldsAccount));
			if(!$fieldsValid) break; 
		}

		return $fieldsValid;
	}
}
?>
