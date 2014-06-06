<?php
namespace AIESEC\Portal\DataBundle\Service;

/**
 * Class holding all constants necessary for Salesforce backend
 * communication.
 *
 * @author felix
 *
 * 2014/06/03 - created
 */
class DBConstantsGoal
{
	const TYPE_GOAL = 'Goal__c';
	
	const TABLE_NAME_GOAL = 'Goal__c';
	const CHILD_RELATIONSHIP_NAME = 'Goals__r';
	
	const DB_GOAL_ID = 'Id';
	const DB_GOAL_NAME = 'Name';
	const DB_GOAL_CAREER_STEP = 'Career_Step__c';
	const DB_GOAL_CURRENT_STATE = 'Current_State__c';
	const DB_GOAL_DESCRIPTION = 'Description__c';
	const DB_GOAL_DUE_DATE = 'Due_Date__c';
	const DB_GOAL_PERCENTAGE = 'Percentage__c';
	const DB_GOAL_SUBTYPE = 'Subtype__c';
	const DB_GOAL_TYPE = 'Type__c';
	
	public static $QUERY_FIELDS_GOAL = array(
		self::DB_GOAL_ID,
		self::DB_GOAL_NAME,
		self::DB_GOAL_CAREER_STEP,
		self::DB_GOAL_CURRENT_STATE,
		self::DB_GOAL_DESCRIPTION,
		self::DB_GOAL_DUE_DATE,
		self::DB_GOAL_PERCENTAGE,
		self::DB_GOAL_SUBTYPE,
		self::DB_GOAL_TYPE,
	);
}
