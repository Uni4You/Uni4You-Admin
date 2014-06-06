<?php
namespace AIESEC\Portal\DataBundle\Service;

/**
 * 
 * @author Felix Goroncy
 *
 * 2014/05/16 - created
 */
class DBConstantsTimeslot{
	const CHILD_RELATION_TIMESLOT_OFFERED = 'Available_Timeslots__r';
	const CHILD_RELATION_TIMESLOT_BOOKED = 'Booked_Timeslots__r';
	const TYPE_TIMESLOT = 'Timeslot__c';
	const MASTER_DETAIL_RELATIONSHIP = 'Account__r';
	const BOOKED_BY_RELATION = 'Booked_by__r';
	
	const DB_TIMESLOT_ID = 'Id';
	const DB_TIMESLOT_OWNER = 'Account__c';
	const DB_TIMESLOT_BOOKED_BY = 'Booked_by__c';
	const DB_TIMESLOT_BOOKING_COMMENT = 'Booking_Comment__c';
	const DB_TIMESLOT_SUMMARY = 'Booking_Summary__c';
	const DB_TIMESLOT_BOOKING_TYPE = 'Booking_Type__c';
	const DB_TIMESLOT_DURATION = 'Duration__c';
	const DB_TIMESLOT_START_DATE = 'Start_Date__c';
	
	const DB_TIMESLOT_AVAILABLE = 'Is_available__c';
	
	public static $QUERY_FIELDS_TIMESLOT = array(
			self::DB_TIMESLOT_ID,
			self::DB_TIMESLOT_OWNER,
			self::DB_TIMESLOT_BOOKED_BY,
			self::DB_TIMESLOT_BOOKING_COMMENT,
			self::DB_TIMESLOT_SUMMARY,
			self::DB_TIMESLOT_BOOKING_TYPE,
			self::DB_TIMESLOT_DURATION,
			self::DB_TIMESLOT_START_DATE,
	);
}