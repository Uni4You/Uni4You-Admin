<?php
namespace AIESEC\Portal\DataBundle\Service;
use AIESEC\Portal\DataBundle\Service\DBConstantsOpportunity;
use AIESEC\Portal\DataBundle\Entity\Opportunity;

/**
 * Class acting as interface between the underlaying data model
 * on Salesforce and the MyExperienceOnline platform.
 *
 * @author Felix Goroncy
 *        
 *         2014/05/29 - creation
 */
class OpportunityService extends DataService
{

	public function getOpportunity ($id, $accountOwnerId)
	{
		$query = "SELECT " . implode(", ", DBConstantsOpportunity::$QUERY_FIELDS_OPPORTUNITY) . ", " .
				 DBConstantsOpportunity::CONTACT_RELATIONSHIP_NAME . '.' . DBConstantsOpportunity::DB_OPPORTUNITY_CONTACT_PERSON_NAME . " from " .
				 DBConstantsOpportunity::TABLE_NAME_OPPORTUNITY;
		
		// Load only open Opportunities
		$where = " " . DBConstantsOpportunity::DB_OPPORTUNITY_IS_OPEN . " = " . DBConstants::SF_TRUE;
		
		$where .= " and " . DBConstantsOpportunity::DB_OPPORTUNITY_CLOSING_DATE . " >= TODAY";
		
		// Load only Opportunities that are either national or local and owned
		// by the User's LC
		$where .= " and (" . DBConstantsOpportunity::DB_OPPORTUNITY_SCOPE . " = '" . DBValuesOpportunity::$DB_VALUES_SCOPE[1] . "' or (" .
				DBConstantsOpportunity::DB_OPPORTUNITY_SCOPE . " = '" . DBValuesOpportunity::$DB_VALUES_SCOPE[0] . "' and " .
				DBConstantsOpportunity::DB_OPPORTUNITY_OWNER_ID . " = '" . $accountOwnerId . "'))";
		
		$where .= " and " . DBConstantsOpportunity::DB_OPPORTUNITY_ID . " = '$id'";
		
		$query .= " where $where";

		$queryResult = $this->getSFConnection()->query($query);
		
		$records = $queryResult->records;

		if (count($records) == 0)
			return null;
		foreach ($records as $record) {
			$oportunitySObject = new \SObject($record);
			break;
		}
		
		return self::sObjectToOpportunityWrapper($oportunitySObject);
	}

	/**
	 * Gets all Opportunities from Salesforce.
	 * Query can be minimized
	 * by passing non-null values for the method parameter.
	 * <p/><b>Attention:</b> Is only able to return up to 200 records in
	 * the current implementation!
	 *
	 * @return array
	 */
	public function getOpportunities ($accountOwnerId)
	{
		$query = "SELECT " . implode(", ", DBConstantsOpportunity::$QUERY_FIELDS_OPPORTUNITY) . ", " .
				 DBConstantsOpportunity::CONTACT_RELATIONSHIP_NAME . '.' . DBConstantsOpportunity::DB_OPPORTUNITY_CONTACT_PERSON_NAME . " from " .
				 DBConstantsOpportunity::TABLE_NAME_OPPORTUNITY;
		
		$where = "";
		
		// Load only open Opportunities
		$where .= " " . DBConstantsOpportunity::DB_OPPORTUNITY_IS_OPEN . " = " . DBConstants::SF_TRUE;
		
		$where .= " and " . DBConstantsOpportunity::DB_OPPORTUNITY_CLOSING_DATE . " >= TODAY";
		
		// Load only Opportunities that are either national or local and owned
		// by the User's LC
		$where .= " and (" . DBConstantsOpportunity::DB_OPPORTUNITY_SCOPE . " = '" . DBValuesOpportunity::$DB_VALUES_SCOPE[1] . "' or (" .
				 DBConstantsOpportunity::DB_OPPORTUNITY_SCOPE . " = '" . DBValuesOpportunity::$DB_VALUES_SCOPE[0] . "' and " .
				 DBConstantsOpportunity::DB_OPPORTUNITY_OWNER_ID . " = '" . $accountOwnerId . "'))";
		
		if (strlen($where) > 0)
			$query .= " where $where";
		
		$queryResult = $this->getSFConnection()->query($query);
		
		$records = $queryResult->records;
		
		$opportunities = array();
		foreach ($records as $record) {
			$oportunitySObject = new \SObject($record);
			$opportunities[] = self::sObjectToOpportunityWrapper($oportunitySObject);
		}
		
		return $opportunities;
	}

	private static function sObjectToOpportunityWrapper ($oportunitySObject)
	{
		// opportunity object representing the data model of Salesforce
		$sObject = new \SObject($oportunitySObject);
		$fields = (array) ($sObject->fields);
		
		$opportunity = new Opportunity();
		$opportunity->setId($sObject->Id);
		
		$opportunity->setTitle($fields[DBConstantsOpportunity::DB_OPPORTUNITY_TITLE]);
		$opportunity->setSubtitle($fields[DBConstantsOpportunity::DB_OPPORTUNITY_SUBTITLE]);
		$opportunity->setApplicationForm($fields[DBConstantsOpportunity::DB_OPPORTUNITY_APPLICATION_FORM]);
		
		$opportunity->setClosingDate($fields[DBConstantsOpportunity::DB_OPPORTUNITY_CLOSING_DATE]);
		$opportunity->setOpeningDate($fields[DBConstantsOpportunity::DB_OPPORTUNITY_OPENING_DATE]);
		
		$cityLc = array_search($fields[DBConstantsOpportunity::DB_OPPORTUNITY_CITY_LC], DBValuesOpportunity::$DB_VALUES_CITY_LC);
		if ($cityLc !== false)
			$opportunity->setCityLc($cityLc);
		
		$name = (array) $fields[DBConstantsOpportunity::CONTACT_RELATIONSHIP_NAME]->fields;
		$name = $name[DBConstantsOpportunity::DB_OPPORTUNITY_CONTACT_PERSON_NAME];
		$opportunity->setContactPersonName($name);
		
		$opportunity->setContactPerson($fields[DBConstantsOpportunity::DB_OPPORTUNITY_CONTACT_PERSON]);
		$opportunity->setContactEmail($fields[DBConstantsOpportunity::DB_OPPORTUNITY_CONTACT_EMAIL]);
		$opportunity->setContactPhone($fields[DBConstantsOpportunity::DB_OPPORTUNITY_CONTACT_PHONE]);
		$opportunity->setDescription($fields[DBConstantsOpportunity::DB_OPPORTUNITY_DESCRIPTION]);
		$opportunity->setCurrentlyOpen($fields[DBConstantsOpportunity::DB_OPPORTUNITY_IS_OPEN] === DBConstants::SF_TRUE);
		$opportunity->setRequirements($fields[DBConstantsOpportunity::DB_OPPORTUNITY_REQUIREMENTS]);
		
		$scope = array_search($fields[DBConstantsOpportunity::DB_OPPORTUNITY_SCOPE], DBValuesOpportunity::$DB_VALUES_SCOPE);
		if ($scope !== false)
			$opportunity->setScope($scope);
		
		$type = array_search($fields[DBConstantsOpportunity::DB_OPPORTUNITY_TYPE], DBValuesOpportunity::$DB_VALUES_TYPE);
		if ($type !== false)
			$opportunity->setType($type);
		
		$subtype = array_search($fields[DBConstantsOpportunity::DB_OPPORTUNITY_SUBTYPE], DBValuesOpportunity::$DB_VALUES_SUBTYPE);
		if ($subtype !== false)
			$opportunity->setSubType($subtype);
		
		return $opportunity;
	}
}