<?php
namespace AIESEC\Portal\DataBundle\Service;
use AIESEC\Portal\DataBundle\Entity\Job;
use AIESEC\Portal\DataBundle\Entity\Membership;

/**
 * Class acting as interface between the underlaying data model
 * on Salesforce and the MyExperienceOnline platform.
 * 
 * @author Felix Goroncy
 *
 * 2014/04/27 - creation
 */
class MembershipService extends DataService
{
	
	public static function sObjectToMembershipWrapper($membershipSObject, $flags = 0)
	{
		//membership object representing the data model of Salesforce
		$sObject = new \SObject($membershipSObject);
		//var_dump($sObject);
		$fields = (array)($sObject->fields);
		
		//membership object representing the data model of MyExperienceOnline
		$membership = new Membership();
		
		$membership->setSId($sObject->Id);
		
		//set membership status => transformation from salesforce picklist to class constants
		if($fields[DBConstantsMembership::DB_MEMBERSHIP_MEMBERSHIP_STATUS] === 
			DBValuesMembership::$DB_VALUES_MEMBERSHIP_STATUS['active']){
			$membership->setMemberType(Membership::MEMBER_TYPE_ACTIVE);
		}//else{ keep default }
		
		$membership->setDateOfJoining($fields[DBConstantsMembership::DB_MEMBERSHIP_DATE_OF_JOINING]);
		$membership->setHasSpendSemesterAbroad(DBConstants::SF_TRUE ===
				$fields[DBConstantsMembership::DB_MEMBERSHIP_SPEND_SEMESTER_ABROAD]);
		$membership->setHasDriversLicense(DBConstants::SF_TRUE ===
				$fields[DBConstantsMembership::DB_MEMBERSHIP_DRIVERS_LICENSE]);
		$membership->setSkypeId($fields[DBConstantsMembership::DB_MEMBERSHIP_SKYPE_ID]);
		$membership->setRequestedWorkshops(
				explode(";",$fields[DBConstantsMembership::DB_MEMBERSHIP_REQUESTED_WORKSHOPS]));
		
		$membership->setHasInterestedInTLP(DBConstants::SF_TRUE ===
				$fields[DBConstantsMembership::DB_MEMBERSHIP_INTERESTED_IN_TLP]);
		$membership->setDetailsTLP($fields[DBConstantsMembership::DB_MEMBERSHIP_DETAILS_TLP]);
		
		$membership->setHasInterestInExchange(DBConstants::SF_TRUE ===
				$fields[DBConstantsMembership::DB_MEMBERSHIP_INTEREST_IN_EXCHANGE]);
		//there are only 2 possibilities for exchange type: GCDP, GIP
		$type = $fields[DBConstantsMembership::DB_MEMBERSHIP_TYPE_OF_EXCHANGE];
		$membership->setTypeOfExchange(isset(DBValuesMembership::$DB_VALUES_EXCHANGE_TYPE[$type])? 
				DBValuesMembership::$DB_VALUES_EXCHANGE_TYPE[$type] : Membership::EXCHANGE_TYPE_NONE);
		$membership->setPossibleStartOfExchange(
				$fields[DBConstantsMembership::DB_MEMBERSHIP_POSSIBLE_DATE_FOR_EXCHANGE]);
		$membership->setDetailsExchange(
				$fields[DBConstantsMembership::DB_MEMBERSHIP_DETAILS_OF_EXCHANGE]);
		
		$membership->setHasInterestInTrainerEducation(DBConstants::SF_TRUE ===
				$fields[DBConstantsMembership::DB_MEMBERSHIP_INTEREST_IN_TRAINER]);
		$membership->setDetailsTrainerEducation(
				$fields[DBConstantsMembership::DB_MEMBERSHIP_DETAILS_TRAINER_EDUCATION]);
		
		
		$membership->setAbleToHostInterns(DBConstants::SF_TRUE ===
				$fields[DBConstantsMembership::DB_MEMBERSHIP_CAN_HOST_INTERNS]);
		
		$membership->setHasCar(DBConstants::SF_TRUE ===
				$fields[DBConstantsMembership::DB_MEMBERSHIP_HAS_CAR]);
		
		//in case deep database access was not performed jobs will not be created and default
		// false will remain in the membership object!
		if(($flags & DataService::FLAG_JOBS) != 0){
			$jobs = array();
			if(isset($membershipSObject->queryResult))
			{
				foreach ($membershipSObject->queryResult as $subQueryResult) {
					foreach ($subQueryResult->records as $subRecord) {
						$subquerySObject = new \SObject($subRecord);
						if ($subRecord->type === DBConstantsMembership::TYPE_JOB){
							// record describes a career step aka job
							$job = JobService::sObjectToJobWrapper($subquerySObject);
							$jobs[$subquerySObject->Id] = $job;
						}
					}
				}
			}
			$membership->setJobs($jobs);
		}
		
		return $membership;
	}
	
	/**
	 * Not all membership data is needed at all times. This
	 * includes information about career steps aka jobs.
	 * This information is not acquired from the default
	 * account querying process and has to be added seperately
	 * via this function.
	 * 
	 * @param unknown $membership
	 * @param unknown $sfConnection
	 */
	public function loadMembershipJobInformation($membership){
		$query = "SELECT ".implode(", ",DBConstantsMembership::$QUERY_FIELDS_JOB).
			" from Job__c".
			" a where ".DBConstantsMembership::DB_JOB_PARENT." = ".
			"'".$membership->getSId()."'".
			" order by ".DBConstantsMembership::DB_JOB_DATE_STARTED;
		
		$queryResult = $this->getSFConnection()->query($query);
		
		$jobs = array();
		$records = $queryResult->records;
		foreach ($records as $record) {
			$jobSObject = new \SObject($record);
			$job = DataServiceMembership::sObjectToJobWrapper($jobSObject);
			$jobs[$jobSObject->Id] = $job;
		}
		
		return $jobs;
	}
	
	/**
	 * 
	 * @param unknown $membership
	 */
	public static function getFieldsForUpdateFromMembership(Membership $membership){
		$fields = array(
			DBConstantsMembership::DB_MEMBERSHIP_DRIVERS_LICENSE => $membership->getHasDriversLicense(),
			DBConstantsMembership::DB_MEMBERSHIP_HAS_CAR => $membership->getHasCar(),
			DBConstantsMembership::DB_MEMBERSHIP_SKYPE_ID => $membership->getSkypeId(),
			
				/* getRequestedWorkshops allways returns an array -> fields to null probably not necessary
				 * TODO: Test if empty array is excepted by salesforce */
			DBConstantsMembership::DB_MEMBERSHIP_REQUESTED_WORKSHOPS => $membership->getRequestedWorkshops(),
// 			DBConstantsMembership::DB_MEMBERSHIP_INTERESTED_IN_TLP => $membership->getHasInterestedInTLP(),
				/* getDetails allways returns a string.
				 * TODO: test what happens to empty strings in salesforce */
// 			DBConstantsMembership::DB_MEMBERSHIP_DETAILS_TLP => $membership->getDetailsTLP(),
// 			DBConstantsMembership::DB_MEMBERSHIP_INTEREST_IN_EXCHANGE => $membership->getHasInterestInExchange(),
				/* getDetails allways returns a string.
				 * TODO: test what happens to empty strings in salesforce */
// 			DBConstantsMembership::DB_MEMBERSHIP_DETAILS_OF_EXCHANGE => $membership->getDetailsExchange(),
			DBConstantsMembership::DB_MEMBERSHIP_CAN_HOST_INTERNS => $membership->isAbleToHostInterns(),
			DBConstantsMembership::DB_MEMBERSHIP_SPEND_SEMESTER_ABROAD => $membership->getHasSpendSemesterAbroad(),
		);
		
		$fieldsToNull = array();
		if($membership->getSkypeId() == null)
			$fieldsToNull[] = DBConstantsMembership::DB_MEMBERSHIP_SKYPE_ID;
		
// 		if($membership->getTypeOfExchange() == Membership::EXCHANGE_TYPE_NONE)
// 			$fieldsToNull[] = DBConstantsMembership::DB_MEMBERSHIP_TYPE_OF_EXCHANGE;
// 		else
// 			$fields[DBConstantsMembership::DB_MEMBERSHIP_TYPE_OF_EXCHANGE] = $membership->getTypeOfExchange();


		if(count($membership->getRequestedWorkshops()) === 0)
			$fieldsToNull[] = DBConstantsMembership::DB_MEMBERSHIP_REQUESTED_WORKSHOPS;
		else
			$fields[DBConstantsMembership::DB_MEMBERSHIP_REQUESTED_WORKSHOPS] = $membership->getRequestedWorkshops();


		//implode multible choice fields and set date types to format salesforce understands
		$fields = array_map(array('AIESEC\Portal\DataBundle\Service\DataService','databaseFieldsMapper'),$fields);
		//remove null fields
		$fields = array_filter($fields, create_function('$field','return !($field===NULL);'));
		
		
		return array(
			"fields" => $fields,
			"fieldsToNull" => $fieldsToNull,
		);		
	}
}