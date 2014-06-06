<?php
namespace AIESEC\Portal\DataBundle\Service;
use AIESEC\Portal\DataBundle\Entity\Goal;

/**
 * Class acting as interface between the underlaying data model
 * on Salesforce and the MyExperienceOnline platform.
 *
 * @author Felix Goroncy
 *
 * 2014/06/03 - creation
 */
class GoalService extends DataService
{
	const GOAL_NULL = 1;
	
	public static function sObjectToGoalWrapper($sObject){
		$goal = new Goal();
		
		$goal->setId($sObject->Id);
		
		$fields = (array)$sObject->fields;
		
		$goal->setCurrentState($fields[DBConstantsGoal::DB_GOAL_CURRENT_STATE]);
		$goal->setDescription($fields[DBConstantsGoal::DB_GOAL_DESCRIPTION]);
		$goal->setDueDate($fields[DBConstantsGoal::DB_GOAL_DUE_DATE]);
		$goal->setJobId($fields[DBConstantsGoal::DB_GOAL_CAREER_STEP]);
		$goal->setPercentage(floatval($fields[DBConstantsGoal::DB_GOAL_PERCENTAGE]));
 		$goal->setSubtype(array_search ( $fields [DBConstantsGoal::DB_GOAL_SUBTYPE],
			DBValuesGoal::$DB_VALUES_GOAL_SUBTYPE));
		$goal->setType(array_search ( $fields [DBConstantsGoal::DB_GOAL_TYPE],
			DBValuesGoal::$DB_VALUES_GOAL_TYPE));
		
		return $goal;
	}
	
	/**
	 * Method to reload goals for already loaded job information.
	 * 
	 * @param unknown $jobs
	 */
	public function reloadGoals($jobs){
		if(count($jobs) > 0){
			/* assume that the keys for the job array
			 * are the ids in the database */
			$keys = array_keys($jobs);
			
			/* Set goals of all jobs to null to differentiate between
			 * jobs without goals and jobs where goals have not been
			 * loaded yet. */
			foreach($jobs as $job) $job->setGoals(null);
		
			
			/* Construct query for database access. */
			$setOfIds = "('".implode("', '", $keys)."')";
			$query = "SELECT ".implode(", ",DBConstantsGoal::$QUERY_FIELDS_GOAL).
					" from ".DBConstantsGoal::TABLE_NAME_GOAL.
					" where ".DBConstantsGoal::DB_GOAL_CAREER_STEP. " IN $setOfIds";
			
			/* Access database */
			$queryResult = $this->getSFConnection()->query($query);
			$records = $queryResult->records;

			
			/* generate all goal objects and add them to corresponding
			 * Job object.*/
			foreach ($records as $record) {
				$goalSObject = new \SObject($record);
				$goal = self::sObjectToGoalWrapper($goalSObject);
				$key = $goal->getJobId();
				$jobs[$key]->addGoal($goal);
			}
		}
		
		return $jobs;
	}
	
	/**
	 * Updates information of passed goal in database backend.
	 * No authentification is performed, that is the goal is
	 * changed without testing if it is a goal of the current
	 * account.
	 * 
	 * @param Goal $goal
	 */
	public function updateGoalFromObject(Goal $goal){
		$fields = array(
			DBConstantsGoal::DB_GOAL_NAME => $goal->getName(),
			//Job id is probably not changable
			DBConstantsGoal::DB_GOAL_CURRENT_STATE => $goal->getCurrentState(),
			DBConstantsGoal::DB_GOAL_DESCRIPTION => $goal->getDescription(),
			DBConstantsGoal::DB_GOAL_DUE_DATE => $goal->getDueDate(),
			DBConstantsGoal::DB_GOAL_PERCENTAGE => $goal->getPercentage(),
			DBConstantsGoal::DB_GOAL_TYPE => (isset(DBValuesGoal::$DB_VALUES_GOAL_TYPE[$goal->getType()])?
				DBValuesGoal::$DB_VALUES_GOAL_TYPE[$goal->getType()]:null),
			DBConstantsGoal::DB_GOAL_SUBTYPE => (isset(DBValuesGoal::$DB_VALUES_GOAL_SUBTYPE[$goal->getSubtype()])?
				DBValuesGoal::$DB_VALUES_GOAL_SUBTYPE[$goal->getSubtype()]:null),
		);
		
		//implode multible choice fields and set date types to format salesforce understands
		$fields = array_map(array('AIESEC\Portal\DataBundle\Service\DataService','databaseFieldsMapper'),$fields);
		//remove null fields
		$fields = array_filter($fields, create_function('$field','return !($field===NULL);'));
		
		$this->updateGoal($goal->getId(), $fields);
	}
	
	/**
	 * This function updates the values in <code>$fields</code> of
	 * the Salesforce 'Goal' object referenced by $sId.</p>
	 * All securrity checks have to be done before!
	 */
	private function updateGoal($sId, $fields, $fieldsToNull = null) {
		$sObject = new \sObject ();
		$sObject->type = DBConstantsGoal::TYPE_GOAL;
		$sObject->Id = $sId;
		$sObject->fields = $fields;
		$sObject->fieldsToNull = $fieldsToNull;
	
		// TODO: catch exceptions
		$response = $this->getSFConnection()->update(array($sObject));
		return $response;
	}
	
}