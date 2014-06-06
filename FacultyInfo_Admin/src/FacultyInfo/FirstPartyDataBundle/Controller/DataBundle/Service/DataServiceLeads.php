<?php
namespace AIESEC\Portal\DataBundle\Service;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use AIESEC\Portal\DataBundle\Entity\Lead;


class DataServiceLeads
{
	const DB_RECORD_TYPE = "RecordTypeId";
	static $DB_VALUES_RECORD_TYPE = array(
		'ep' => '01220000000MHoeAAG',	
	);
	
	const DB_LEAD_SOURCE = "LeadSource";

	const DB_EMAIL = "Email";
	const DB_FIRST_NAME = "FirstName";
	const DB_LAST_NAME = "LastName";
	const DB_GENDER = "Gender__c";
	const DB_PHONE = "MobilePhone";
	const DB_BIRTH_DATE = "Birth_Date__c";

	const DB_UNIVERSITY = "University__c";
	const DB_LOCAL_COMMITTEE = "closest_city__c";
	const DB_AREA_OF_STUDIES = "Area_of_Studies__c";
	const DB_COURSE_OF_STUDIES = "courseOfStudies__c";
	const DB_SEMESTER = "Semester__c";
	const DB_GRADUATION_YEAR = "When_do_you_graduate__c";
	const DB_STUDENT = "Are_you_a_student__c";
	const DB_DEGREE_TYPE = "Degree_Type__c";
	const DB_LANGUAGE_LEVEL_EXCELLENT = "Language_Level_Excellent__c";
	const DB_LANGUAGE_LEVEL_NATIVE = "Language_Level_Native__c";
	const DB_LANGUAGE_LEVEL_GOOD = "Language_Level_Good__c";

	const DB_PRACTICAL_EXPERIENCE = "previousInternshipExperiences__c";
	const DB_PRACTICAL_EXPERIENCE_DESCRIPTION = "previousInternshipDetails__c";
	const DB_VOLUNTARY_ENGAGEMENT = "voluntaryEngagement__c";
	const DB_VOLUNTARY_ENGAGEMENT_DESCRIPTION = "voluntaryEngagementDetails__c";

	const DB_FOCUS_OF_INTERNSHIP = "Focus_of_Internship__c";
	const DB_INTERESTING_AREAS_OF_IT = "interestingAreasOfIT__c";
	const DB_IT_SKILLS = "itSkills__c";
	const DB_EARLIEST_START_DATE = "Earliest_Startdate__c";
	const DB_LATEST_END_DATE = "Latest_End_Date__c";
	const DB_MINIMUM_DURATION = "Minimum_Duration_of_Internship__c";
	const DB_MAXIMUM_DURATION = "Maximum_Duration_of_Internship__c";
	const DB_WORLD_AREAS_OF_INTEREST = "Area_of_world_interested_in_going__c";
	const DB_COUNTRIES_OF_INTEREST = "specific_countries__c";
	const DB_MOTIVATION = "motivation_for_exchange__c";
	const DB_WAY_OF_FINDING_AIESEC = "How_did_you_hear_about_AIESEC__c";
	const DB_COMMENTS = "Other_Comments_Questions__c";

	const DB_FLEXIBILITY_IN_FOCUS_AND_COUNTRY = "flexibilityRegardingJobDestination__c";
	const DB_MEMBER_OF_AIESEC = "Are_you_currently_a_member_of_AIESEC__c";

	public static $DB_VALUES_AREA_OF_STUDIES = array(
			"Administration / Business / Commerce / Management",
			"Arts / Humanities","Computer Science",
			"Economics / Political Science / Public Affairs",
			"Education","Engineering","International / Development Studies",
			"Law","Masters / MBA","Sciences","Other",
			"Agrar-, Forst-, Haushalts- und Ernährungswissenschaften",
			"Gesundheitswissenschaften, Medizin","Ingenieurwissenschaften",
			"Kunst, Musik","Mathematik, Naturwissenschaften",
			"Rechts-, Wirtschafts- und Sozialwissenschaften",
			"Sprach- und Kulturwissenschaften",
	);

	public static $DB_VALUES_FOCUS_GCDP = array(
			"change" => "GCDP - Change",
			"entrepreneur" => "GCDP - Entrepreneur",
			"language" => "GCDP - Language",
	);

	public static $DB_VALUES_FOCUS_GIP = array(
			"accountingFinance" => "GIP - Accounting & Finance",
			"business" => "GIP - Business Administration",
			"engineering" => "GIP - Engineering",
			"it" => "GIP - Information Technology",
			"marketing" => "GIP - Marketing",
			"teaching" => "GIP - Teaching",
	);

	public static $DB_VALUES_INTERESTING_AREAS_OF_IT = array(
			"administration" => "Administration",
			"desktop" => "Desktop Software Development",
			"mobile" => "Mobile Development",
			"server" => "Server Software Development",
			"web" => "Web Development",
	);

	public static $DB_VALUES_IT_SKILLS = array(
			"ajax" => "AJAX","asp.net" => "ASP.NET","c_cpp" => "C/C++",
			"c#" => "C#","css" => "CSS","html5" => "HTML5",
			"java" => "Java","js" => "JavaScript",
			"objective_c" => "Objective C","perl" => "Perl",
			"php" => "PHP","python" => "Python","ruby" => "Ruby",
			"sql" => "SQL","tcp_ip" => "TCP/IP",
			"unix_shell" => "Unix Shell Scripting","xml" => "XML",
	);

	public static $DB_VALUES_WAY_OF_FINDING_AIESEC = array(
			"friend" => "A Friend","website" => "AIESEC Website",
			"member" => "An AIESEC Member","presentation" => "Classroom Presentations",
			"colleaguePartner" => "Colleague or partner",
			"infoStand" => "Information Stand at my University",
			"media" => "Media","other" => "Other","poster" => "Poster",
			"searchEngine" => "Search Engine","socialMedia" => "Social Media",
			"someone" => "Someone who took an AIESEC Experience",
			"globalWebsite" => "AIESEC Global Website",
	);

	public static $DB_VALUES_WORLD_AREAS_OF_INTEREST = array(
			"africa" => "Africa","ap" => "AP","cee" => "CEE",
			"ign" => "IGN","mena" => "MENA",
			"westernEuropeNorthAmerica" => "Western Europe & North America",
	);

	public static $DB_VALUES_COUNTRIES_OF_INTEREST = array(
			"bahrain" => "Bahrain","brazil" => "Brazil",
			"cambodia" => "Cambodia","china" => "China","colombia" => "Colombia",
			"czech_republic" => "Czech Republic","egypt" => "Egypt","ghana" => "Ghana",
			"hungary" => "Hungary","india" => "India","indonesia" => "Indonesia",
			"italy" => "Italy","kenya" => "Kenya","malaysia" => "Malaysia",
			"mexico" => "Mexico","peru" => "Peru","philippines" => "Philippines",
			"poland" => "Poland","russia" => "Russia","southern_cone" => "Southern Cone",
			"sri_lanka" => "Sri Lanka","taiwan" => "Taiwan","tanzania" => "Tanzania",
			"turkey" => "Turkey","uganda" => "Uganda","vietnam" => "Vietnam",
	);

	private static function leadToSObjectWrapper($lead){
		$focusCombined = array_merge(
				self::$DB_VALUES_FOCUS_GCDP,self::$DB_VALUES_FOCUS_GIP);

		$sObject = new \sObject();
		$sObject->type = DBConstants::TYPE_LEAD;

		$fields = array(
				self::DB_FIRST_NAME=>$lead->firstName,
				self::DB_LAST_NAME=>$lead->lastName,
				self::DB_GENDER
				=>isset(DBValues::$DB_VALUES_GENDER[$lead->gender])? DBValues::$DB_VALUES_GENDER[$lead->gender]:null,
				self::DB_EMAIL=>$lead->email, //is used to identify acc in salesforce
				self::DB_PHONE=>$lead->phone,
				self::DB_BIRTH_DATE=>$lead->birthdate,

				self::DB_UNIVERSITY
				=>isset(DBValues::$DB_VALUES_UNIVERSITY[$lead->university])? DBValues::$DB_VALUES_UNIVERSITY[$lead->university]:null,
				self::DB_AREA_OF_STUDIES
				=>isset($DB_VALUES_AREA_OF_STUDIES[$lead->areaOfStudies])? $DB_VALUES_AREA_OF_STUDIES[$lead->areaOfStudies]:null,
				self::DB_SEMESTER=>$lead->semester,
				self::DB_GRADUATION_YEAR
				=>isset(DBValues::$DB_VALUES_GRADUATION_YEAR[$lead->graduationYear])? DBValues::$DB_VALUES_GRADUATION_YEAR[$lead->graduationYear]:null,
				self::DB_STUDENT
				=>isset(DBValues::$DB_VALUES_YES_NO[$lead->student])? DBValues::$DB_VALUES_YES_NO[$lead->student]:null,
				self::DB_DEGREE_TYPE
				=>isset(DBValues::$DB_VALUES_DEGREE_TYPE[$lead->degreeType])? DBValues::$DB_VALUES_DEGREE_TYPE[$lead->degreeType]:null,
				self::DB_LANGUAGE_LEVEL_EXCELLENT=>$lead->languagesExcellent,
				self::DB_LANGUAGE_LEVEL_GOOD=>$lead->languagesGood,
				self::DB_LANGUAGE_LEVEL_NATIVE=>$lead->languagesNative,

				self::DB_PRACTICAL_EXPERIENCE
				=>isset(DBValues::$DB_VALUES_YES_NO[$lead->practicalExperience])? DBValues::$DB_VALUES_YES_NO[$lead->practicalExperience]:null,
				self::DB_PRACTICAL_EXPERIENCE_DESCRIPTION => $lead->practicalExperienceDescription,
				self::DB_VOLUNTARY_ENGAGEMENT
				=>isset(DBValues::$DB_VALUES_YES_NO[$lead->voluntaryWork])? DBValues::$DB_VALUES_YES_NO[$lead->voluntaryWork]:null,
				self::DB_VOLUNTARY_ENGAGEMENT_DESCRIPTION => $lead->voluntaryWorkDescription,

				self::DB_FOCUS_OF_INTERNSHIP
				=>isset($focusCombined[$lead->focus])? $focusCombined[$lead->focus]:null,
				self::DB_INTERESTING_AREAS_OF_IT => $lead->focusForIt,
				self::DB_IT_SKILLS => $lead->itSkills,

				self::DB_EARLIEST_START_DATE => $lead->earliestStartDate,
				self::DB_LATEST_END_DATE => $lead->latestStartDate,
				self::DB_MINIMUM_DURATION => $lead->minDuration,
				self::DB_MAXIMUM_DURATION => $lead->maxDuration,

				self::DB_WORLD_AREAS_OF_INTEREST => $lead->worldAreasOfInterest,
				self::DB_COUNTRIES_OF_INTEREST => $lead->countriesOfInterest,
				self::DB_MOTIVATION => $lead->letterOfMotivation,

				self::DB_COURSE_OF_STUDIES => $lead->courseOfStudies,
				self::DB_MEMBER_OF_AIESEC
				=>isset(DBValues::$DB_VALUES_YES_NO[$lead->inAiesec])? DBValues::$DB_VALUES_YES_NO[$lead->inAiesec]:null,
				self::DB_FLEXIBILITY_IN_FOCUS_AND_COUNTRY => $lead->flexibilityFocusOfInternshipAndCountry,

				self::DB_WAY_OF_FINDING_AIESEC
				=>isset(self::$DB_VALUES_WAY_OF_FINDING_AIESEC[$lead->wayOfFindingAiesec])? self::$DB_VALUES_WAY_OF_FINDING_AIESEC[$lead->wayOfFindingAiesec]:null,
				self::DB_COMMENTS => $lead->additionalComments,
		);

		switch($lead->type){
			case Lead::TYPE_GIP:
				$fields[self::DB_RECORD_TYPE] = self::$DB_VALUES_RECORD_TYPE['ep'];
				$fields[self::DB_LEAD_SOURCE] = "Global Citizen";
				break;
			case Lead::TYPE_GCDP:
				$fields[self::DB_RECORD_TYPE] = self::$DB_VALUES_RECORD_TYPE['ep'];
				$fields[self::DB_LEAD_SOURCE] = "Global Talent";
				break;
			default:
				//TODO: log
				break;
		}
		//todo: when ready change to name from lead
		$fields[self::DB_EMAIL] = '00001@email.de';
		$fields['FirstName'] = 'Max (NIST test lead)';
		$fields['LastName'] = 'Mustermann';

		//implode multible choice fields and set date types to format salesforce understands
		$fields = array_map(array('AIESEC\Portal\DataBundle\Service\DataService','databaseFieldsMapper'),$fields);
		//remove null fields
		$fields = array_filter($fields, create_function('$field','return !($field===NULL);'));

		$sObject->fields = $fields;
			
		return $sObject;
	}

	public static function insertLeadGlobalCitizen($lead, $sfConnection){
		//die('keks');
		$response = $sfConnection
		->create(array(DataServiceLeads::leadToSObjectWrapper($lead)));

		//if cv is attached it has to be uploaded and attached to
		//the created lead
		if($response[0]->success){
			if (($CVFile = $lead->cv) != null) {
				$file_size = filesize($CVFile);
				if ($file_size > DBConstants::MAX_FILESIZE) {
					//return DataService::FILE_TOO_BIG;
				} else {
					// mimeType should be checked by symfony beforehand
					$handle = fopen($CVFile, "r");
					$content = fread($handle, $file_size);
					fclose($handle);
						
					// create sObject
					$sObject = new \sObject();
					$sObject->type = 'Attachment';
					$attachmentFields = array();
					$attachmentFields['parentId'] = $response[0]->id;
					$attachmentFields['name'] = $CVFile->getClientOriginalName();
					$encoded = chunk_split(base64_encode($content));
					$attachmentFields['body'] = $encoded;
					$attachmentFields['Description'] = DBValues::ATTACHMENT_DESCRIPTION_CV;
					$sObject->fields = $attachmentFields;
					// $attachmentsToUpload[] = $sObject;
					$attachmentResult = $sfConnection->create(array(
							$sObject	
					));
					
					var_dump($attachmentResult);
				}
			}
				
		}
		
		var_dump($response);

		return $response;
	}

	public static function getLead($sfConnection){
		//get all field names
		$res = $sfConnection->describeSObject("Lead");
		//print_r($res);

		$fieldsAsArray = array();
		foreach($res->fields as $fieldObject){
			$fieldsAsArray[] = $fieldObject->name;
		}
		unset($fieldsAsArray[0]);
		$fields = implode(', ',$fieldsAsArray);

		$queryResult = $sfConnection->query("SELECT ".$fields." from Lead where ".self::DB_EMAIL." = '00001@email.de'");
		$records = $queryResult->records;
		
		foreach($records as $record){
			$sObject = new \SObject($record);
			$sObjectAsArray = (array)$sObject->fields;
			$fields = array();
 			foreach($fieldsAsArray as $field)
 				$fields[$field] = $sObjectAsArray[$field];
			print_r($fields);
 			echo '</br></br>';
		}

		return $records;
	}
}