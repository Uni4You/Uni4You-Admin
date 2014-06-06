<?php
namespace AIESEC\Portal\DataBundle\Service;
use AIESEC\Portal\DataBundle\Entity\Opportunity;

class DBConstantsOpportunity
{
	const TABLE_NAME_OPPORTUNITY = 'Opportunity__c';
	
	const DB_OPPORTUNITY_OWNER_ID = "OwnerId";
	
	const DB_OPPORTUNITY_APPLICATION_FORM = 'Application_Form__c';
	const DB_OPPORTUNITY_CITY_LC = 'City_LC__c';
	const DB_OPPORTUNITY_CLOSING_DATE = 'Closing_Date__c';
	const DB_OPPORTUNITY_CONTACT_EMAIL = 'Contact_Email__c';
	const DB_OPPORTUNITY_CONTACT_PERSON = 'Contact_Person__c';
	const DB_OPPORTUNITY_CONTACT_PHONE = 'Contact_Phone__c';
	const DB_OPPORTUNITY_DESCRIPTION = 'Description__c';
	const DB_OPPORTUNITY_IS_OPEN = 'Is_currently_open__c';
	const DB_OPPORTUNITY_OPENING_DATE = 'Opening_Date__c';
	const DB_OPPORTUNITY_REQUIREMENTS = 'Requirements__c';
	const DB_OPPORTUNITY_SCOPE = 'Scope__c';
	const DB_OPPORTUNITY_SUBTITLE = 'Subtitle__c';
	const DB_OPPORTUNITY_SUBTYPE = 'Subtype__c';
	const DB_OPPORTUNITY_TYPE = 'Type__c';
	
	const DB_OPPORTUNITY_TITLE = 'Name';
	const DB_OPPORTUNITY_ID = 'Id';
	
	const DB_OPPORTUNITY_CONTACT_PERSON_NAME = 'Name';
	const CONTACT_RELATIONSHIP_NAME = 'Contact_Person__r'; 

	
	public static $QUERY_FIELDS_OPPORTUNITY = array(
			self::DB_OPPORTUNITY_APPLICATION_FORM,
			self::DB_OPPORTUNITY_CITY_LC,
			self::DB_OPPORTUNITY_CLOSING_DATE,
			self::DB_OPPORTUNITY_CONTACT_EMAIL,
			self::DB_OPPORTUNITY_CONTACT_PERSON,
			self::DB_OPPORTUNITY_CONTACT_PHONE,
			self::DB_OPPORTUNITY_DESCRIPTION,
			self::DB_OPPORTUNITY_IS_OPEN,
			self::DB_OPPORTUNITY_OPENING_DATE,
			self::DB_OPPORTUNITY_REQUIREMENTS,
			self::DB_OPPORTUNITY_SCOPE,
			self::DB_OPPORTUNITY_SUBTITLE,
			self::DB_OPPORTUNITY_SUBTYPE,
			self::DB_OPPORTUNITY_TYPE,
			self::DB_OPPORTUNITY_TITLE,
			self::DB_OPPORTUNITY_ID,
	);
}