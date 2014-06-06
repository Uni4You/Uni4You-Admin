<?php
namespace AIESEC\Portal\DataBundle\Service;

/**
 * Class holding all constants necessary for Salesforce backend
 * communication.
 * 
 * @author felix
 *
 * 2014/04/27 - created
 */
class DBConstantsMembership
{
	//API name of job object in Salesforce backend
	const TYPE_JOB = 'Job__c';
	const TABLE_NAME_JOB = 'Career_Steps__r';
	const MASTER_DETAIL_RELATIONSHIP = 'Account__r';
	
	//==== list of Membship object fields ===
	/* *********************************************
	 *  these fields are stored in the Account object
	 * in the salesforce backend but moved to an
	 * seperate Membership object in the MXO platform
	 * to improve readability!
	 * *********************************************/
	const DB_MEMBERSHIP_IS_WAS_MEMBER = 'Is_Member_Alumnus__c';
	const DB_MEMBERSHIP_MEMBERSHIP_STATUS = 'Membership_Status__c';
	const DB_MEMBERSHIP_DATE_OF_JOINING = 'Date_of_Joining__c';
	const DB_MEMBERSHIP_SPEND_SEMESTER_ABROAD = 'Semester_abroad__c';
	const DB_MEMBERSHIP_DRIVERS_LICENSE = 'Drivers_License__c';
	const DB_MEMBERSHIP_SKYPE_ID = 'Skype_Id__c';
	const DB_MEMBERSHIP_REQUESTED_WORKSHOPS = 'Requested_Workshops__c';
	const DB_MEMBERSHIP_INTERESTED_IN_TLP = 'Interested_in_TLP_Position__c';
	const DB_MEMBERSHIP_DETAILS_TLP = 'Details_TLP__c';
	const DB_MEMBERSHIP_INTEREST_IN_EXCHANGE = 'Interested_in_Exchange_Program__c';
	const DB_MEMBERSHIP_TYPE_OF_EXCHANGE = 'Exchange_Type_of_Interest__c';
	const DB_MEMBERSHIP_POSSIBLE_DATE_FOR_EXCHANGE = 'Possible_Exchange_Date__c';
	const DB_MEMBERSHIP_DETAILS_OF_EXCHANGE = 'Details_Exchange__c';
	const DB_MEMBERSHIP_INTEREST_IN_TRAINER = 'Interested_in_Trainer_Education__c';
	const DB_MEMBERSHIP_DETAILS_TRAINER_EDUCATION = 'Details_Trainer_Education__c';
	const DB_MEMBERSHIP_CAN_HOST_INTERNS = 'Can_host_interns__c';
	const DB_MEMBERSHIP_HAS_CAR = 'Has_Car__c';
	
	
	//====== list of Job object fields ======
	
	const DB_JOB_ID = "Id";
	const DB_JOB_PARENT = 'Account__c';
	const DB_JOB_NAME = 'Name';
	const DB_JOB_DATE_STARTED = 'Started__c';
	const DB_JOB_DATE_ENDED = 'Ended__c';
	const DB_JOB_FUNCTIONAL_EMAIL = 'Functional_Email__c';
	const DB_JOB_TEAM_LEADER = 'Team_Leader__c';
	const DB_JOB_DESCRIPTION = 'Job_Description__c';
	const DB_JOB_POSITION = 'Position__c';
	const DB_JOB_POSITION_NAME = 'Position_Name__c';
	const DB_JOB_LC = 'LC__c';
	const DB_JOB_TEAM_NAME = 'Team_Name__c';
	const DB_JOB_TEAM_TYPE = 'Team_Type__c';
	const DB_JOB_TEAM_SUB_TYPE = 'Team_Subtype__c';
	const DB_JOB_YOUTH_TALENT_PROGRAM = 'Youth_Talent_Program__c';
	const DB_JOB_TIME_INVESTED = 'Time_invested__c';
	const DB_JOB_IS_ACTIVE = 'Is_Active__c';
	
	/**
	 * Array used to make query generation simpler and more clear.
	 * All fields that are to be used from the salesforce object
	 * HAVE to be listed here.
	 */
	public static $QUERY_FIELDS_JOB = array(
			self::DB_JOB_NAME,
			self::DB_JOB_DATE_STARTED,
			self::DB_JOB_DATE_ENDED,
			self::DB_JOB_FUNCTIONAL_EMAIL,
			self::DB_JOB_TEAM_LEADER,
			self::DB_JOB_DESCRIPTION,
			self::DB_JOB_POSITION,
			self::DB_JOB_POSITION_NAME,
			self::DB_JOB_LC,
			self::DB_JOB_TEAM_NAME,
			self::DB_JOB_TEAM_TYPE,
			self::DB_JOB_TEAM_SUB_TYPE,
			self::DB_JOB_YOUTH_TALENT_PROGRAM,
			self::DB_JOB_TIME_INVESTED,
			self::DB_JOB_ID,
	);
}