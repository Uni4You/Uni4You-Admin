<?php
namespace AIESEC\Portal\DataBundle\Service;
use AIESEC\Portal\DataBundle\Entity\ICC;
class DataServiceICC
{
	public static function sObjectToICCWrapper($ICCSObject)
	{
		$Id = $ICCSObject->Id;
		$name = $ICCSObject->Name;
		$active = ($ICCSObject->fields->Active__c == DBConstants::SF_TRUE);
		$city = $ICCSObject->fields->City_LC__c;
		$startDate = $ICCSObject->fields->StartDate__c;
		$endDate = $ICCSObject->fields->End_Date__c;
		$registrationLink = $ICCSObject->fields->Registration_Link__c;

		$icc = new ICC($Id,
		        $name,
				$active,
				$city,
				$startDate,
				$endDate,
				$registrationLink);

		return $icc;
	}
	
	public static function getICCs ($sfConnection)
	{
		$query = "SELECT ".implode(", ",DBConstants::$QUERY_FIELDS_ICC).
		" from ".DBConstants::TABLE_NAME_ICC.
		" order by ".DBConstants::DB_ICC_START_DATE;

		$queryResult = $sfConnection->query($query);
		$records = $queryResult->records;

		if(count($records) == 0) {
			return null;
		}
		
		$ICCs = array();
		foreach ($records as $record) {
			$ICCSObject = new \SObject($record);
			$ICCs[] = DataServiceICC::sObjectToICCWrapper($ICCSObject);
		}

		return $ICCs;
	}
}