<?php
namespace AIESEC\Portal\DataBundle\Service;
class DBConstants
{
	const TYPE_EP = "EP__c";
	const TYPE_ACCOUNT = 'Account';
	const TYPE_LEAD = 'Lead';
	const TABLE_NAME_EP = "EPs__r";
	const TABLE_NAME_ACCOUNT = "Account";
	const TABLE_NAME_ICC = "ICC__c";

	const MAX_FILESIZE = 5000000;

	const SF_TRUE = "true";
	const SF_FALSE = "false";

	const DB_ACCOUNT_ID = "Id";
	const DB_OWNER_ID = "OwnerId";
	const DB_OWNER_NAME = "OwnerName__c";
	const DB_FIRST_NAME = "FirstName";
	const DB_LAST_NAME = "LastName";
	const DB_GENDER = "Gender__c";
	const DB_PERSON_EMAIL = "PersonEmail";
	const DB_SKYPE_ID = 'Skype_Id__c';
	const DB_PHONE = "Phone";
	const DB_BIRTH_DATE = "Birth_Date__c";
	const DB_BIRTH_PLACE = 'Place_of_Birth__c';
	const DB_UNIVERSITY = "University__c";
	const DB_AREA_OF_STUDIES = "Area_of_Studies__c";
	const DB_SEMESTER = "Semester__c";
	const DB_GRADUATION_YEAR = "Graduation_Year__c";
	const DB_STUDENT = "Student__c";
	const DB_DEGREE_TYPE = "Degree_Type__c";
	const DB_ADDRESS = "Address__c";
	const DB_ZIP = "ZIP__c";
	const DB_CITY = "City__c";
	const DB_LANGUAGE_LEVEL_EXCELLENT = "Language_Level_Excellent__c";
	const DB_LANGUAGE_LEVEL_GOOD = "Language_Level_Good__c";
	const DB_LANGUAGE_LEVEL_NATIVE = "Language_Level_Native__c";
	const DB_CV_DATE = "CV_Date__c";
	const DB_CV_UPLOADED = "CV_Uploaded__c";
	const DB_ICC = "ICC__c";
	const DB_ICC_NECESSARY = "ICC_necessary__c";
	
	const DB_PASSWORD = "Password__c";
	const DB_PASSWORD_RESET_NEEDED = "isPortalPasswordResetNeeded__c";
	const DB_PASSWORD_RESET_HASH = "portalPasswordResetHash__c";
	const DB_PASSWORD_RESET_HASH_DATE = "portalPasswordResetHashCreationDate__c";
	
	const DB_BANK_NAME = "Bank_Name__c";
	const DB_BANK_ACCOUNT_OWNER = "Bank_Account_Owner__c";
	const DB_BIC = "BIC__c";
	const DB_IBAN = "IBAN__c";

	//================== EP ===================
	const DB_EP_ID = "Id";
	const DB_GIPGCDP = "GIPGCDP_Portal__c";
	const DB_AIESEC_EP_ID = "EP_ID__c";
	const DB_TN_ID = "TN_ID__c";
	
	const DB_EARLIEST_START_DATE = "Earliest_StartDate__c";
	const DB_LATEST_END_DATE = "Latest_EndDate__c";
	const DB_MINIMUM_DURATION = "Minimum_Duration__c";
	const DB_MAXIMUM_DURATION = "Maximum_Duration__c";
	const DB_EP_STATUS = "EP_Status__c";
	const DB_REALIZE_DATE = "Realize_Date__c";
	const DB_RETURN_DATE = "Return_Date__c";
	const DB_REINTEGRATION_ACTIVITY_COMPLETED = "Reintegration_Activity_completed__c";

	const DB_AGB_LAGUAGE = "AGB_Language__c";
	const DB_AGB_VERSION = "AGB_Version__c";
	const DB_SIGNED_AGB = "Signed_AGB_PDF__c";
	const DB_DATE_AGB_SIGNED = "Date_AGB_Signed__c";
	const DB_AGB_STATUS = "AGB_Status__c";
	
	const DB_ENROLLMENT_CERTIFICATE_UPLOADED = "enrollmentCertificateUploaded__c";
	const DB_ENROLLMENT_CERTIFICATE_DATE = "enrollmentCertificateDate__c";

	const DB_SIGNED_STUDENT_CONTRACT = "Signed_Student_Contract_PDF__c";

	const DB_ACCEPTANCE_NOTE = "Acceptance_Note_uploaded__c";
	const DB_AN_UPLOAD_DATE = "AN_Upload_Date__c";
	
	const DB_DATE_EXPERIENCE_REPORT_UPLOADED = "Date_Internship_Report_Uploaded__c";

	const DB_IS_DISPLAYED_IN_PORTAL = "isDisplayedInPortal__c";
	const DB_IS_EDITABLE_IN_PORTAL = "isEditableInPortal__c";
	
	const DB_AMOUNT_OF_ICC_FEE = 'Amount_of_ICC_fee__c';
	const DB_AMOUNT_OF_INPAYMENT = 'Amount_of_inpayment__c';
	const DB_AMOUNT_OF_MATCHING_FEE = 'Amount_of_matching_fee__c';
	const DB_AMOUNT_OF_PEDS_FEE = 'Amount_of_PEDS_fee__c';
	const DB_AMOUNT_OF_RAISING_FEE = 'Amount_of_Raising_fee__c';
	const DB_AMOUNT_OF_REFUNDING = 'Amount_of_refunding__c';
	const DB_AMOUNT_OF_RETENTION = 'Amount_of_retention__c';


	//================== ICC ===================
	const DB_ICC_ID = "Id";
	const DB_ICC_NAME = "Name";
	const DB_ICC_ACTIVE = "Active__c";
	const DB_ICC_CITY_LC = "City_LC__c";
	const DB_ICC_START_DATE = "StartDate__c";
	const DB_ICC_END_DATE = "End_Date__c";
	const DB_ICC_REGISTRATION_LINK = "Registration_Link__c";



	public static $modifyableFieldsAccount = array(
		//self::DB_ACCOUNT_ID, //database intern, should not be changable
		//self::DB_FIRST_NAME, //poses as key for many LCs
		//self::DB_LAST_NAME, //see DB_FIRST_NAME
		self::DB_GENDER,
		//self::DB_PERSON_EMAIL, //is used to identify acc in salesforce
		self::DB_PHONE,
		self::DB_BIRTH_DATE,
		self::DB_BIRTH_PLACE,
		self::DB_UNIVERSITY,
		self::DB_AREA_OF_STUDIES,
		self::DB_SEMESTER,
		self::DB_GRADUATION_YEAR,
		self::DB_STUDENT,
		self::DB_DEGREE_TYPE,
		self::DB_ADDRESS,
		self::DB_ZIP,
		self::DB_CITY,
		self::DB_LANGUAGE_LEVEL_EXCELLENT,
		self::DB_LANGUAGE_LEVEL_GOOD,
		self::DB_LANGUAGE_LEVEL_NATIVE,
		self::DB_CV_DATE,
		self::DB_CV_UPLOADED,
		self::DB_ICC,
		self::DB_BANK_NAME,
		self::DB_BANK_ACCOUNT_OWNER,
		self::DB_BIC,
		self::DB_IBAN,
		//self::DB_ICC_NECESSARY,
		self::DB_PASSWORD,
		self::DB_PASSWORD_RESET_NEEDED,
		self::DB_PASSWORD_RESET_HASH,
		self::DB_PASSWORD_RESET_HASH_DATE,

		DBConstantsMembership::DB_MEMBERSHIP_DRIVERS_LICENSE,
		DBConstantsMembership::DB_MEMBERSHIP_HAS_CAR,
		DBConstantsMembership::DB_MEMBERSHIP_SKYPE_ID,
		DBConstantsMembership::DB_MEMBERSHIP_CAN_HOST_INTERNS,
		DBConstantsMembership::DB_MEMBERSHIP_SPEND_SEMESTER_ABROAD,
		DBConstantsMembership::DB_MEMBERSHIP_REQUESTED_WORKSHOPS,
	);

	public static $QUERY_FIELDS_ACCOUNT = array(
		self::DB_ACCOUNT_ID, //database intern, should not be changable
		self::DB_OWNER_ID,
		self::DB_FIRST_NAME, //poses as key for many LCs
		self::DB_LAST_NAME, //see DB_FIRST_NAME
		self::DB_GENDER,
		self::DB_PERSON_EMAIL, //is used to identify acc in salesforce
		self::DB_PHONE,
		self::DB_BIRTH_DATE,
		self::DB_BIRTH_PLACE,
		self::DB_UNIVERSITY,
		self::DB_AREA_OF_STUDIES,
		self::DB_SEMESTER,
		self::DB_GRADUATION_YEAR,
		self::DB_STUDENT,
		self::DB_DEGREE_TYPE,
		self::DB_ADDRESS,
		self::DB_ZIP,
		self::DB_CITY,
		self::DB_LANGUAGE_LEVEL_EXCELLENT,
		self::DB_LANGUAGE_LEVEL_GOOD,
		self::DB_LANGUAGE_LEVEL_NATIVE,
		self::DB_CV_DATE,
		self::DB_CV_UPLOADED,
		self::DB_ICC,
		self::DB_ICC_NECESSARY,
		self::DB_BANK_NAME,
		self::DB_BANK_ACCOUNT_OWNER,
		self::DB_BIC,
		self::DB_IBAN,
		self::DB_PASSWORD,
		self::DB_PASSWORD_RESET_NEEDED,
		self::DB_PASSWORD_RESET_HASH,
		self::DB_PASSWORD_RESET_HASH_DATE,
		self::DB_OWNER_NAME,
		
		DBConstantsMembership::DB_MEMBERSHIP_IS_WAS_MEMBER,
		DBConstantsMembership::DB_MEMBERSHIP_MEMBERSHIP_STATUS,
		DBConstantsMembership::DB_MEMBERSHIP_DATE_OF_JOINING,
		DBConstantsMembership::DB_MEMBERSHIP_SPEND_SEMESTER_ABROAD,
		DBConstantsMembership::DB_MEMBERSHIP_DRIVERS_LICENSE,
		DBConstantsMembership::DB_MEMBERSHIP_SKYPE_ID,
		DBConstantsMembership::DB_MEMBERSHIP_REQUESTED_WORKSHOPS,
		DBConstantsMembership::DB_MEMBERSHIP_INTERESTED_IN_TLP,
		DBConstantsMembership::DB_MEMBERSHIP_DETAILS_TLP,
		DBConstantsMembership::DB_MEMBERSHIP_INTEREST_IN_EXCHANGE,
		DBConstantsMembership::DB_MEMBERSHIP_TYPE_OF_EXCHANGE,
		DBConstantsMembership::DB_MEMBERSHIP_POSSIBLE_DATE_FOR_EXCHANGE,
		DBConstantsMembership::DB_MEMBERSHIP_DETAILS_OF_EXCHANGE,
		DBConstantsMembership::DB_MEMBERSHIP_INTEREST_IN_TRAINER,
		DBConstantsMembership::DB_MEMBERSHIP_DETAILS_TRAINER_EDUCATION,
		DBConstantsMembership::DB_MEMBERSHIP_CAN_HOST_INTERNS,
		DBConstantsMembership::DB_MEMBERSHIP_HAS_CAR,
	);

	public static $modifyableFieldsEP = array(
		'state' => array(
			self::DB_GIPGCDP,
			self::DB_EARLIEST_START_DATE,
			self::DB_LATEST_END_DATE,
			self::DB_MINIMUM_DURATION,
			self::DB_MAXIMUM_DURATION,

			self::DB_AGB_LAGUAGE,
			self::DB_AGB_VERSION,
			self::DB_SIGNED_AGB,
			self::DB_DATE_AGB_SIGNED,
			self::DB_AGB_STATUS,

			self::DB_ENROLLMENT_CERTIFICATE_UPLOADED,
			self::DB_ENROLLMENT_CERTIFICATE_DATE,

			self::DB_SIGNED_STUDENT_CONTRACT,

			self::DB_ACCEPTANCE_NOTE,
			self::DB_AN_UPLOAD_DATE,
				
			self::DB_DATE_EXPERIENCE_REPORT_UPLOADED,

			self::DB_IS_DISPLAYED_IN_PORTAL,
			self::DB_IS_EDITABLE_IN_PORTAL,

			),
	);

	public static $QUERY_FIELDS_EP = array(
		self::DB_EP_ID,
		self::DB_GIPGCDP,
		self::DB_AIESEC_EP_ID,
		self::DB_TN_ID,
			
		self::DB_EARLIEST_START_DATE,
		self::DB_LATEST_END_DATE,
		self::DB_MINIMUM_DURATION,
		self::DB_MAXIMUM_DURATION,
		self::DB_EP_STATUS,
		self::DB_REALIZE_DATE,
		self::DB_RETURN_DATE,
		self::DB_REINTEGRATION_ACTIVITY_COMPLETED,
				
		self::DB_AGB_LAGUAGE,
		self::DB_AGB_VERSION,
		self::DB_SIGNED_AGB,
		self::DB_DATE_AGB_SIGNED,
		self::DB_AGB_STATUS,
		
		self::DB_ENROLLMENT_CERTIFICATE_UPLOADED,
		self::DB_ENROLLMENT_CERTIFICATE_DATE,

		self::DB_SIGNED_STUDENT_CONTRACT,

		self::DB_ACCEPTANCE_NOTE,
		self::DB_AN_UPLOAD_DATE,
			
		self::DB_DATE_EXPERIENCE_REPORT_UPLOADED,

		self::DB_IS_DISPLAYED_IN_PORTAL,
		self::DB_IS_EDITABLE_IN_PORTAL,
		
		self::DB_AMOUNT_OF_ICC_FEE,
		self::DB_AMOUNT_OF_INPAYMENT,
		self::DB_AMOUNT_OF_MATCHING_FEE,
		self::DB_AMOUNT_OF_PEDS_FEE,
		self::DB_AMOUNT_OF_RAISING_FEE,
		self::DB_AMOUNT_OF_REFUNDING,
		self::DB_AMOUNT_OF_RETENTION,
	);
	
	
	public static $QUERY_FIELDS_ICC = array(
		self::DB_ICC_ID,
	    self::DB_ICC_NAME,
		self::DB_ICC_ACTIVE,
		self::DB_ICC_CITY_LC,
		self::DB_ICC_START_DATE,
		self::DB_ICC_END_DATE,
		self::DB_ICC_REGISTRATION_LINK,
	);
}

	//================== EP ===================
?>