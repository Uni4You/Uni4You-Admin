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
 * 2014/05/17 - creation
 */
class JobService extends DataService
{
	/**
	 * Function to transform Salesforce data model
	 * for Job object to data model of platform.
	 *
	 * @param unknown $jobSObject
	 * @return \AIESEC\Portal\DataBundle\Entity\Job
	 * 		object representing a career step of an AIESEC member.
	 */
	public static function sObjectToJobWrapper($jobSObject)
	{
		//job object representing the data model of Salesforce
		$sObject = new \SObject($jobSObject);
		$fields = (array)($sObject->fields);
	
		//job object representing the data model of MyExperienceOnline
		$job = new Job();
	
		$job->setId($sObject->Id);
	
		$job->setJobName($fields[DBConstantsMembership::DB_JOB_NAME]);
		$job->setDateStarted($fields[DBConstantsMembership::DB_JOB_DATE_STARTED]);
		$job->setDateEnded($fields[DBConstantsMembership::DB_JOB_DATE_ENDED]);
		$job->setFunctionalEmail($fields[DBConstantsMembership::DB_JOB_FUNCTIONAL_EMAIL]);
		$job->setTeamLeader($fields[DBConstantsMembership::DB_JOB_TEAM_LEADER]);
	
		$job->setJobDescription($fields[DBConstantsMembership::DB_JOB_DESCRIPTION]);
		$job->setPosition(array_search($fields[DBConstantsMembership::DB_JOB_POSITION],
				DBValuesMembership::$DB_VALUES_POSITION));
		$job->setPositionName($fields[DBConstantsMembership::DB_JOB_POSITION_NAME]);
	
		$job->setLc(array_search($fields[DBConstantsMembership::DB_JOB_LC],
				DBValuesMembership::$DB_VALUES_LC));
	
		$job->setTeamName($fields[DBConstantsMembership::DB_JOB_TEAM_NAME]);
		$job->setTeamType(array_search($fields[DBConstantsMembership::DB_JOB_TEAM_TYPE],
				DBValuesMembership::$DB_VALUES_TEAM_TYPE));
		$job->setTeamSubtype(array_search($fields[DBConstantsMembership::DB_JOB_TEAM_SUB_TYPE],
				DBValuesMembership::$DB_VALUES_TEAM_SUBTYPE));
	
		$job->setYouthTalentProgram(array_search($fields[DBConstantsMembership::DB_JOB_YOUTH_TALENT_PROGRAM],
				DBValuesMembership::$DB_VALUES_YOUTH_TALENT_PROGRAM));
	
		$job->setTimeInvested(is_null($fields[DBConstantsMembership::DB_JOB_TIME_INVESTED])?
				NULL:intval($fields[DBConstantsMembership::DB_JOB_TIME_INVESTED]));
	
		return $job;
	}
	
	/**
	 * Load all information corresponding to the job with id
	 * $jobId. Returns a deep object, meaning that subqueries
	 * are processed ass well (e.g. information about conferences
	 * is included completely as well).
	 *
	 * @param unknown $jobId
	 * @param unknown $sfConnection
	 */
	public function getJob($jobId){
		$query = "SELECT ".implode(", ",DBConstantsMembership::$QUERY_FIELDS_JOB).
		" from Job__c".
		" a where ".DBConstantsMembership::DB_JOB_ID." = ".
		"'".$jobId."'";
	
		$queryResult = $this->getSFConnection()->query($query);
	
		$records = $queryResult->records;
		foreach ($records as $record) {
			$jobSObject = new \SObject($record);
			$job = self::sObjectToJobWrapper($jobSObject);
			break; // there should only be one job
		}
	
		//TODO: load conference information as well (ommitted for now)
	
		return $job;
	}
	
	/**
	 * Queries information about all team members. This is done by
	 * looking up
	 * <ol>
	 * <li> the team leader (account object)
	 * <li> every career step with same leader
	 * <li> filtering out those with same team name and overlapping
	 * 		time intervals
	 * <li> getting necessary account information of team members
	 * </ol>
	 *
	 * <p/><b>Attention: <b/>
	 * Might return incomplete results for closed career steps
	 * when parts of the team stopped before the team
	 * leader was changed for the continuing ones!!
	 *
	 * @param unknown $job
	 */
	public function getTeam($job){
		$sfConnection = $this->getSFConnection();
		// ======= querying leader
		//$query = "SELECT ".
	
				// ======= querying member with same team leader in all career steps
		$query = "SELECT ".implode(", ",DBConstantsMembership::$QUERY_FIELDS_JOB).
		" from Job__c".
		" a where ".DBConstantsMembership::DB_JOB_TEAM_LEADER." = ".
		"'".$job->getTeamLeader()."'";
	
		// restrict search to jobs that where not ended when the passed job started
		$query .= " AND (".
				DBConstantsMembership::DB_JOB_DATE_ENDED. " > ".
				$job->getDateStarted()->format("Y-m-d")." OR ".
				DBConstantsMembership::DB_JOB_DATE_ENDED. " = NULL)";
	
		// restrict search to jobs that started before the passed one ended
		if(!$job->isActive()) // meaning there is no end date yet
			$query .= " AND ".DBConstantsMembership::DB_JOB_DATE_STARTED.
			" < ".$job->getDateEnded()->format("Y-m-d");
			
		$query .= " order by ".DBConstantsMembership::DB_JOB_DATE_STARTED;
	
	
		$queryResult = $sfConnection->query($query);
	
		$jobs = array();
		$records = $queryResult->records;
		foreach ($records as $record) {
			$jobSObject = new \SObject($record);
			$job = DataServiceMembership::sObjectToJobWrapper($jobSObject);
			$jobs[] = $job;
		}
	
		var_dump($jobs);
	
		return $jobs;
	
		//TODO: implement
	}

	
	const HR_NOT_SUPPORTED_FOR_TYPE_INTERNATIONAL = 0;
	const HR_UNKNOWN_TEAM_TYPE = 1;
	const HR_NO_VALID_LC_PROVIDED = 2;
	/**
	 * Returns Name and email address of person responsible for
	 * human resources.
	 * This can be used to apply for a certificate based on a
	 * taken career step.
	 * <p/>On local level the curently active VPTM will be queried,
	 * on national level the team leader. On international level as
	 * well as when not finding a suitable account a corresponding
	 * error code will be returned.
	 * @param unknown $job
	 */
	public function getHRResponsible(Job $job){
		switch($job->getTeamType()){
			case Job::TEAM_TYPE_LOCAL:
				/*
				 * Try to find responsible VPTM
				 * Look for corresponding LC, right team type and subtype,
				 * position and activity.
				 * Make sure resulting account is not alumni.
				 */
				
				if(!isset(DBValuesMembership::$DB_VALUES_LC[$job->getLc()]))
					return HR_NO_VALID_LC_PROVIDED;
				
				$query = "SELECT ".
					DBConstantsMembership::MASTER_DETAIL_RELATIONSHIP.".Name".
					", ".DBConstantsMembership::MASTER_DETAIL_RELATIONSHIP.".".DBConstants::DB_PERSON_EMAIL.
					", ".DBConstantsMembership::DB_JOB_FUNCTIONAL_EMAIL;
				
				$query .= " from ".DBConstantsMembership::TYPE_JOB." a where ";
				
				//look for people in the corresponding lc
				$query .= DBConstantsMembership::DB_JOB_LC." = '".DBValuesMembership::$DB_VALUES_LC[$job->getLc()]."'";
				
				//look for only local jobs
				$query .= " AND ".DBConstantsMembership::DB_JOB_TEAM_TYPE." = '".
							DBValuesMembership::$DB_VALUES_TEAM_TYPE[Job::TEAM_TYPE_LOCAL]."'";
				
				//look for the TM team
				$query .= " AND ".DBConstantsMembership::DB_JOB_TEAM_SUB_TYPE." = '".
							DBValuesMembership::$DB_VALUES_TEAM_SUBTYPE[Job::TEAM_SUBTYPE_TM]."'";
				
				//look for the TM team leader (which should be registered as Vice President -> might make problems
				//in case team leader was selected for VPTM!!)
				$query .= " AND ".DBConstantsMembership::DB_JOB_POSITION." = '".
							DBValuesMembership::$DB_VALUES_POSITION[Job::POSITION_VICE_PRESIDENT]."'";
				
				// look only for active once
				$query .= " AND ".DBConstantsMembership::DB_JOB_IS_ACTIVE." = true";
				
				$contacts = null;
				
 				//get account -> how many returned??
 				$queryResult = $this->getSFConnection()->query($query);
 				$records = $queryResult->records;
 				foreach ($records as $record) {
 					$sObject = new \SObject($record);
 					$infoSObject = new \SObject($record->any[DBConstantsMembership::MASTER_DETAIL_RELATIONSHIP]);
 					$fields = ((array)$sObject->fields);
 					$entry[DBConstantsMembership::DB_JOB_FUNCTIONAL_EMAIL] = $fields[DBConstantsMembership::DB_JOB_FUNCTIONAL_EMAIL];
 					$entry = array_merge($entry,(array)($fields[DBConstantsMembership::MASTER_DETAIL_RELATIONSHIP]->fields));
 					$contacts[] = $entry;
 				}
 				
				//TODO: get only non-alumni
				
 				return $contacts;
				
			case Job::TEAM_TYPE_NATIONAL:
				break;
			case Job::TEAM_TYPE_INTERNATIONAL:
				return self::HR_NOT_SUPPORTED_FOR_TYPE_INTERNATIONAL;
			default:
				return self::HR_UNKNOWN_TEAM_TYPE;
		}
	}
}