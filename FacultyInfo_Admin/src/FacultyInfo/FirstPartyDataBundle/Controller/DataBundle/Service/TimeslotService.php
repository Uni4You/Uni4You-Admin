<?php

namespace AIESEC\Portal\DataBundle\Service;

use AIESEC\Portal\DataBundle\Entity\Timeslot;
use AIESEC\Portal\DataBundle\Entity\Job;

/**
 * Class acting as interface between the underlaying data model
 * on Salesforce and the MyExperienceOnline platform.
 *
 * @author Felix Goroncy
 *        
 *         2014/05/16 - creation
 */
class TimeslotService extends DataService {
	const SLOT_NOT_AVAILABLE = 3;
	const SLOT_BOOKED_BY_OTHER = 4;
	const SLOT_NOT_BOOKED = 5;
	const SLOT_DOES_NOT_EXIST = 6;
	const SLOT_OWNED_BY_OTHER = 7;
	const SLOT_ALREADY_BOOKED_BY_YOU = 8;
	
	
	public static function sObjectToTimeslotWrapper($accountSObject, $flags = 0) {
		$fields = ( array ) ($accountSObject->fields);
		
		$timeslot = new Timeslot ();
		
		$timeslot->setId ( $accountSObject->Id );
		
 		$timeslot->setBookedBy( $fields [DBConstantsTimeslot::DB_TIMESLOT_BOOKED_BY]);
		$timeslot->setAccount ( $fields [DBConstantsTimeslot::DB_TIMESLOT_OWNER] );
		$timeslot->setComment ( $fields [DBConstantsTimeslot::DB_TIMESLOT_BOOKING_COMMENT] );
		$timeslot->setSummary ( $fields [DBConstantsTimeslot::DB_TIMESLOT_SUMMARY] );
		$timeslot->setStart ( $fields [DBConstantsTimeslot::DB_TIMESLOT_START_DATE] );
		$timeslot->setDuration ( floatval ( $fields [DBConstantsTimeslot::DB_TIMESLOT_DURATION] ) );
		// slot name is ommitted as it is only of importance for creating an object (standard field)
		$timeslot->setType ( array_search ( $fields [DBConstantsTimeslot::DB_TIMESLOT_BOOKING_TYPE], DBValuesTimeslot::$DB_VALUES_TIMESLOT_TYPE ) );
		
		// information about owner was loaded
		if (isset ( $fields [DBConstantsTimeslot::MASTER_DETAIL_RELATIONSHIP] )) {
			$contactInfo = ( array ) ($fields [DBConstantsTimeslot::MASTER_DETAIL_RELATIONSHIP]->fields);
			$timeslot->setOwnerName ( $contactInfo ["Name"] );
			$timeslot->setOwnerEmail ( $contactInfo [DBConstants::DB_PERSON_EMAIL] );
			$timeslot->setOwnerPhone ( $contactInfo [DBConstants::DB_PHONE] );
			$timeslot->setOwnerSkype ( $contactInfo [DBConstants::DB_SKYPE_ID] );
		}
		// information about booking account was loaded
		if (isset ( $fields [DBConstantsTimeslot::BOOKED_BY_RELATION] )) {
			$contactInfo = ( array ) ($fields [DBConstantsTimeslot::BOOKED_BY_RELATION]->fields);
			$timeslot->setBookerName ( $contactInfo ["Name"] );
			$timeslot->setBookerEmail ( $contactInfo [DBConstants::DB_PERSON_EMAIL] );
			$timeslot->setBookerPhone ( $contactInfo [DBConstants::DB_PHONE] );
			$timeslot->setBookerSkype ( $contactInfo [DBConstants::DB_SKYPE_ID] );
		}
		
// 		var_dump($accountSObject);
		
		return $timeslot;
	}
	
	public function getTimeslot($id){
		$query = "SELECT " . implode(", ", DBConstantsTimeslot::$QUERY_FIELDS_TIMESLOT) .
				" from " . DBConstantsTimeslot::TYPE_TIMESLOT . " a where Id = '$id'";
		
		$queryResult = $this->getSFConnection()->query($query);
		$records = $queryResult->records;
		
		if (count($records) == 0) {
			return null;
		}
		foreach ($records as $record) {
			$timeslotSObject = new \SObject($record);
			break; // should only be one
		}
		
		$timeslot = self::sObjectToTimeslotWrapper($timeslotSObject);
		
		return $timeslot;
		
	}
	
	public function cancelBookedTimeslot($slotId, $accountId){
		$fieldsToNull = array(
			DBConstantsTimeslot::DB_TIMESLOT_BOOKING_COMMENT,
			DBConstantsTimeslot::DB_TIMESLOT_SUMMARY,
			DBConstantsTimeslot::DB_TIMESLOT_BOOKED_BY,
		);
		
		//check if cancelation is possible
		$databaseTimeslot = self::getTimeslot($slotId);
		if(is_null($databaseTimeslot))
			return self::SLOT_DOES_NOT_EXIST;
		if($databaseTimeslot->getBookedBy() === null)
			return self::SLOT_NOT_BOOKED;
		if($databaseTimeslot->getBookedBy() !== $accountId)
			return self::SLOT_BOOKED_BY_OTHER;
		
		return $this->updateTimeslot($slotId, null, $fieldsToNull);
	}
	
	/**
	 * Deletes offered timeslot. If slot was booked notification is sent to
	 * the booker.
	 */ 
	public function cancelOfferedTimeslot($slotId, $accountId){
		//check if cancelation is possible
		$databaseTimeslot = self::getTimeslot($slotId);
		if(is_null($databaseTimeslot))
			return self::SLOT_DOES_NOT_EXIST;
		if($databaseTimeslot->getAccount() !== $accountId)
			return self::SLOT_OWNED_BY_OTHER;

		//TODO: if booked by someone send out notification mail
		
		$response = $this->getSFConnection()->delete(array($slotId));
		return $response;
	}
	
	public function createTimeslot($timeslot, $accountId){
		$sObject = new \sObject ();
		$sObject->type = DBConstantsTimeslot::TYPE_TIMESLOT;
		$sObject->fields = array(
			/** set default name for all timeslots (currently not shown on platform */
			"Name" => "CreatedByMyExperienceOnline",
			DBConstantsTimeslot::DB_TIMESLOT_OWNER => $accountId,
			DBConstantsTimeslot::DB_TIMESLOT_START_DATE => DataService::databaseFieldsMapper($timeslot->getStart()),
			DBConstantsTimeslot::DB_TIMESLOT_DURATION => $timeslot->getDuration(),
			DBConstantsTimeslot::DB_TIMESLOT_BOOKING_TYPE => (isset(DBValuesTimeslot::$DB_VALUES_TIMESLOT_TYPE[$timeslot->getType()])? 
					DBValuesTimeslot::$DB_VALUES_TIMESLOT_TYPE[$timeslot->getType()]:null),
		);
		
		// TODO: catch exceptions
		$response = $this->getSFConnection()->create(array($sObject));
		return $response;
	}
	
	/**
	 * 
	 * @param unknown $timeslot object with comment and summary information that is to be stored
	 * @param unknown $accountId to use as booked_by field. Is supposed to come from session object
	 */
	public function bookTimeslot($timeslot, $accountId){
		$databaseTimeslot = self::getTimeslot($timeslot->getId());
		
		if(is_null($databaseTimeslot)) return self::SLOT_DOES_NOT_EXIST;
		if($databaseTimeslot->getBookedBy() === $accountId) return self::SLOT_ALREADY_BOOKED_BY_YOU;
		if(!$databaseTimeslot->isAvailable()) return self::SLOT_NOT_AVAILABLE;
		
		$fields = array (
				DBConstantsTimeslot::DB_TIMESLOT_BOOKING_COMMENT => $timeslot->getComment(),
				DBConstantsTimeslot::DB_TIMESLOT_SUMMARY => $timeslot->getSummary(),
				DBConstantsTimeslot::DB_TIMESLOT_BOOKED_BY => $accountId,
		);
		
		return $this->updateTimeslot($timeslot->getId(), $fields);
	}
	
	/**
	 * Allow update of timeslot description and summary for timeslots that the account
	 * has booked.
	 * 
	 * @param Timeslot $timeslot
	 * @param unknown $sfConnection
	 */
	public function updateBookedTimeslotFromObject($timeslot, $accountId) {
		$databaseTimeslot = self::getTimeslot($timeslot->getId());
		
		if(is_null($databaseTimeslot)) return self::SLOT_DOES_NOT_EXIST;
		if($databaseTimeslot->getBookedBy() === null) return self::SLOT_NOT_BOOKED;
		if($databaseTimeslot->getBookedBy() !== $accountId) return self::SLOT_BOOKED_BY_OTHER;
		
		$fields = array (
				DBConstantsTimeslot::DB_TIMESLOT_BOOKING_COMMENT => $timeslot->getComment(),
				DBConstantsTimeslot::DB_TIMESLOT_SUMMARY => $timeslot->getSummary(),
		);
		
		// get null fields
		$fieldsToNull = array_keys(array_filter ( $fields, create_function ( '$field', 'return ($field===NULL);' )));
		
		// do the actual database update
		return $this->updateTimeslot($timeslot->getId (), $fields, $fieldsToNull);
	}
	
	public function updateOfferedTimeslotFromObject($timeslot, $accountId) {
		$databaseTimeslot = self::getTimeslot($timeslot->getId());
		
		if(is_null($databaseTimeslot)) return self::SLOT_DOES_NOT_EXIST;
		if($databaseTimeslot->getAccount() !== $accountId) return self::SLOT_OWNED_BY_OTHER;
		if($databaseTimeslot->getBookedBy() !== null) return self::SLOT_BOOKED_BY_OTHER;
		
		$fields = array (
				DBConstantsTimeslot::DB_TIMESLOT_START_DATE => DataService::databaseFieldsMapper($timeslot->getStart()),
				DBConstantsTimeslot::DB_TIMESLOT_DURATION => $timeslot->getDuration (),
				DBConstantsTimeslot::DB_TIMESLOT_BOOKING_TYPE => (isset(DBValuesTimeslot::$DB_VALUES_TIMESLOT_TYPE[$timeslot->getType()])? 
						DBValuesTimeslot::$DB_VALUES_TIMESLOT_TYPE[$timeslot->getType()]:null),
		);
		
		// remove null fields
		$fields = array_filter ( $fields, create_function ( '$field', 'return !($field===NULL);' ) );
		
		// do the actual database update
		return $this->updateTimeslot($timeslot->getId(), $fields);
	}
	
	/**
	 * This function updates the values in <code>$fields</code> of
	 * the Salesforce 'Timeslot' object referenced by $sId.</p>
	 * All securrity checks have to be done before!
	 */
	public function updateTimeslot($sId, $fields, $fieldsToNull = null) {
		$sObject = new \sObject ();
		$sObject->type = DBConstantsTimeslot::TYPE_TIMESLOT;
		$sObject->Id = $sId;
		$sObject->fields = $fields;
		$sObject->fieldsToNull = $fieldsToNull;
		
		// TODO: catch exceptions
		$response = $this->getSFConnection()->update(array($sObject));
		return $response;
	}
	
	/**
	 * Returns the offered timeslots of all teamleaders of the currently
	 * active jobs that are passed as parameter. Goes over all passed
	 * jobs and selects only the active ones with existing team leader.
	 * That way this method can be called directly with all job objects
	 * of the member.
	 * <p/>Can also be called with a single job object.
	 * 
	 * @param unknown $jobs
	 */
	public function getBookableTimeslots($jobs){
		//transform single job object into array
		if($jobs instanceof Job){
			$jobs = array($jobs);
		}
		
		if(!is_array($jobs))
			throw new \Exception("Invalid argument. Must be of type array or Job!");
		
		$teamLeader = array();
		foreach($jobs as $job){
			if($job->isActive() && $job->getTeamLeader() != null){
				$teamLeader[] = $job->getTeamLeader();
			}
		}
		
		if(count($teamLeader) > 0){
			$query = "SELECT ".implode(", ",DBConstantsTimeslot::$QUERY_FIELDS_TIMESLOT);
			// get parent information
			$query .= ", ".DBConstantsTimeslot::MASTER_DETAIL_RELATIONSHIP.".Name".
						", ".DBConstantsTimeslot::MASTER_DETAIL_RELATIONSHIP.".".DBConstants::DB_SKYPE_ID.
						", ".DBConstantsTimeslot::MASTER_DETAIL_RELATIONSHIP.".".DBConstants::DB_PHONE.
						", ".DBConstantsTimeslot::MASTER_DETAIL_RELATIONSHIP.".".DBConstants::DB_PERSON_EMAIL;
				
			$query .= " from ".DBConstantsTimeslot::TYPE_TIMESLOT." where ";
			
			/*
			 * Interestingly enough the IN operation has to be in parantheses. Otherwise it
			 * seams he does not OR but ANDs (from the previous AND probably) the values,
			 * meaning the owner has to be every entry.
			 */
			$query .= DBConstantsTimeslot::DB_TIMESLOT_AVAILABLE."=true AND (".
					DBConstantsTimeslot::DB_TIMESLOT_OWNER." IN ('".implode("','",$teamLeader)."'))";
			
			$queryResult = $this->getSFConnection()->query($query);
			$records = $queryResult->records;
			
			if (count($records) == 0) {
				return array();
			}
			
			foreach ($records as $record) {
				$timeslotSObject = new \SObject($record);
				$timeslots[] = self::sObjectToTimeslotWrapper($timeslotSObject);
			}
			
			return $timeslots;
		}else{
			return array();
		}
	}
}