<?php
namespace AIESEC\Portal\DataBundle\Service;
use AIESEC\Portal\DataBundle\Entity\EP;

class DataServiceEP
{

	public static function sObjectToEPWrapper ($epSObject)
	{
		$Id = $epSObject->Id;
		$GIPGCDP_Portal__c = $epSObject->fields->GIPGCDP_Portal__c;
		$aiesecEpId = $epSObject->fields->EP_ID__c;
		$tnId = $epSObject->fields->TN_ID__c;
		
		$Earliest_StartDate__c = $epSObject->fields->Earliest_StartDate__c;
		$Latest_EndDate__c = $epSObject->fields->Latest_EndDate__c;
		$Minimum_Duration__c = $epSObject->fields->Minimum_Duration__c;
		$Maximum_Duration__c = $epSObject->fields->Maximum_Duration__c;
		$epStatus = $epSObject->fields->EP_Status__c;
		$realizeDate = $epSObject->fields->Realize_Date__c;
		$returnDate = $epSObject->fields->Return_Date__c;
		$reintegrationActivityCompleted = ($epSObject->fields->Reintegration_Activity_completed__c === "Completed");
		
		$AGB_Language__c = $epSObject->fields->AGB_Language__c;
		$AGB_Version__c = $epSObject->fields->AGB_Version__c;
		$Signed_AGB_PDF__c = ($epSObject->fields->Signed_AGB_PDF__c == DBConstants::SF_TRUE);
		$Date_AGB_Signed__c = $epSObject->fields->Date_AGB_Signed__c;
		
		// only save the key in the representing constant array from DBConstants
		$AGB_Status__c = array_search($epSObject->fields->AGB_Status__c, DBValues::$DB_VALUES_AGB_STATUS, true);
		if ($AGB_Status__c === false)
			$AGB_Status__c = null;
		
		$isEnrollmentCertificateUploaded = ($epSObject->fields->enrollmentCertificateUploaded__c == DBConstants::SF_TRUE);
		$dateEnrollmentCertificateUploaded = $epSObject->fields->enrollmentCertificateDate__c;
		
		$Signed_Student_Contract_PDF__c = ($epSObject->fields->Signed_Student_Contract_PDF__c == DBConstants::SF_TRUE);
		$Acceptance_Note_uploaded__c = ($epSObject->fields->Acceptance_Note_uploaded__c == DBConstants::SF_TRUE);
		$AN_Upload_Date__c = $epSObject->fields->AN_Upload_Date__c;
		
		$dateExperienceReportUploaded = $epSObject->fields->Date_Internship_Report_Uploaded__c;
		
		$isDisplayedInPortal__c = ($epSObject->fields->isDisplayedInPortal__c == DBConstants::SF_TRUE);
		$isEditableInPortal__c = ($epSObject->fields->isEditableInPortal__c == DBConstants::SF_TRUE);
		
		$amountICCFee = $epSObject->fields->Amount_of_ICC_fee__c;
		$amountInpayment = $epSObject->fields->Amount_of_inpayment__c;
		$amountMatchingFee = $epSObject->fields->Amount_of_matching_fee__c;
		$amountPEDSFee = $epSObject->fields->Amount_of_PEDS_fee__c;
		$amountRaisingFee = $epSObject->fields->Amount_of_Raising_fee__c;
		$amountRefunding = $epSObject->fields->Amount_of_refunding__c;
		$amountRetention = $epSObject->fields->Amount_of_retention__c;
		
		$ep = new EP($Id, $GIPGCDP_Portal__c, $aiesecEpId, $tnId,
				$Earliest_StartDate__c, $Latest_EndDate__c, $Minimum_Duration__c, $Maximum_Duration__c,
				$epStatus, $realizeDate, $returnDate, $reintegrationActivityCompleted,
				$AGB_Language__c, $AGB_Version__c, $Signed_AGB_PDF__c, $Date_AGB_Signed__c, $AGB_Status__c, $Signed_Student_Contract_PDF__c, 
				$Acceptance_Note_uploaded__c, $AN_Upload_Date__c, 

				$isEnrollmentCertificateUploaded, $dateEnrollmentCertificateUploaded,

				$dateExperienceReportUploaded,

				$isDisplayedInPortal__c, $isEditableInPortal__c, $amountICCFee, $amountInpayment, $amountMatchingFee, $amountPEDSFee, 
				$amountRaisingFee, $amountRefunding, $amountRetention);
		
		return $ep;
	}

	public static function getEP ($key, $value, $sfConnection)
	{
		if ($key == null || trim($key) === "" || $value == null || trim($value) === "") {
			return null;
		}
		// BUG: escaping $value might be necessary.
		// $value should only be set by platform and
		// not by user and thus be save though.
		
		$query = "SELECT " . implode(", ", DBConstants::$QUERY_FIELDS_EP) . " from " . DBConstants::TYPE_EP . " a where $key = '$value'";
		
		$queryResult = $sfConnection->query($query);
		$records = $queryResult->records;
		
		if (count($records) == 0) {
			return null;
		}
		foreach ($records as $record) {
			$epSObject = new \SObject($record);
			break; // should only be one
		}
		
		$ep = DataServiceEP::sObjectToEPWrapper($epSObject);
		
		return $ep;
	}
	
	// ====================== writing to database ========================
	public static function updateEPContractsFromObject ($ep, $state, $sfConnection)
	{
		$fields = array();
		$attachmentsToUpload = array();
		
		// test if AGB file is already present in salesforce
		if (! $ep->isSignedAGBasPDF()) {
			if (($AGBFile = $ep->getAGBFile()) != null) {
				$file_size = filesize($AGBFile);
				if ($file_size > DBConstants::MAX_FILESIZE) {
					return DataService::FILE_TOO_BIG;
				} else {
					// mimeType should be checked by symfony beforehand
					$handle = fopen($AGBFile, "r");
					$content = fread($handle, $file_size);
					fclose($handle);
					
					// create sObject
					$sObject = new \sObject();
					$sObject->type = 'Attachment';
					$attachmentFields = array();
					$attachmentFields['parentId'] = $ep->getId();
					$attachmentFields['name'] = $AGBFile->getClientOriginalName();
					$encoded = chunk_split(base64_encode($content));
					$attachmentFields['body'] = $encoded;
					$attachmentFields['Description'] = DBValues::ATTACHMENT_DESCRIPTION_AGB_SIGNED;
					$sObject->fields = $attachmentFields;
					// $attachmentsToUpload[] = $sObject;
					$result = $sfConnection->create(array(
							$sObject
					));
					$uploadAGB = $result[0]->success;
				}
			}
		}
		
		// AN not necessary at the moment
		// // TODO: test if file already exists
		// if(($ANFile = $ep->getANFile()) != null){
		// $file_size = filesize($ANFile);
		// if($file_size > DBConstants::MAX_FILESIZE){
		// return DataService::FILE_TOO_BIG;
		// }else{
		// //mimeType should be checked by symfony beforehand
		// $handle = fopen($ANFile, "r");
		// $content = fread($handle, $file_size);
		// fclose($handle);
		//
		// //create sObject
		// $sObject = new \sObject();
		// $sObject->type = 'Attachment';
		// $attachmentFields = array();
		// $attachmentFields['parentId'] = $ep->getId();
		// $attachmentFields['name'] = 'an'.time().'.pdf';
		// $encoded = chunk_split(base64_encode($content));
		// $attachmentFields['body'] = $encoded;
		// $sObject->fields = $attachmentFields;
		// $attachmentsToUpload[] = $sObject;
		// $uploadAN = true;
		// }
		// }
		
		// upload imma
		if (($file = $ep->getCertificateOfEnrollment()) != null) {
			$file_size = filesize($file);
			
			$handle = fopen($file, "r");
			$content = fread($handle, $file_size);
			fclose($handle);
			
			// create sObject
			$sObject = new \sObject();
			$sObject->type = 'Attachment';
			$attachmentFields = array();
			$attachmentFields['parentId'] = $ep->getId();
			$attachmentFields['name'] = $file->getClientOriginalName();
			$encoded = chunk_split(base64_encode($content));
			$attachmentFields['body'] = $encoded;
			$attachmentFields['Description'] = DBValues::ATTACHMENT_DESCRIPTION_CERTIFICATE_OF_ENROLLMENT;
			$sObject->fields = $attachmentFields;
			// $attachmentsToUpload[] = $sObject;
			$result = $sfConnection->create(array(
					$sObject
			));
			$uploadCertificateOfEnrollment = $result[0]->success;
		}
		
		//upload experience report
		if (($file = $ep->getExperienceReport()) != null) {
			$file_size = filesize($file);
			
			$handle = fopen($file, "r");
			$content = fread($handle, $file_size);
			fclose($handle);
			
			// create sObject
			$sObject = new \sObject();
			$sObject->type = 'Attachment';
			$attachmentFields = array();
			$attachmentFields['parentId'] = $ep->getId();
			$attachmentFields['name'] = $file->getClientOriginalName();
			$encoded = chunk_split(base64_encode($content));
			$attachmentFields['body'] = $encoded;
			$attachmentFields['Description'] = DBValues::ATTACHMENT_DESCRIPTION_EXPERIENCE_REPORT;
			$sObject->fields = $attachmentFields;
			// $attachmentsToUpload[] = $sObject;
			$result = $sfConnection->create(array(
					$sObject
			));
			$uploadExperienceReport = $result[0]->success;
		}
		
			//upload experience report promotion pictures
		if(isset($ep->promotionalPictures) && is_array($ep->promotionalPictures)){
			foreach($ep->promotionalPictures as $file){
				if($file == null)
					continue;
				$file_size = filesize($file);
				
				$handle = fopen($file, "r");
				$content = fread($handle, $file_size);
				fclose($handle);
				
				// create sObject
				$sObject = new \sObject();
				$sObject->type = 'Attachment';
				$attachmentFields = array();
				$attachmentFields['parentId'] = $ep->getId();
				$attachmentFields['name'] = $file->getClientOriginalName();
				$encoded = chunk_split(base64_encode($content));
				$attachmentFields['body'] = $encoded;
				$attachmentFields['Description'] = DBValues::ATTACHMENT_DESCRIPTION_EXPERIENCE_REPORT_PROMO;
				$sObject->fields = $attachmentFields;
				// $attachmentsToUpload[] = $sObject;
				$result = $sfConnection->create(array(
						$sObject
				));
			}
		}
		
		// upload attachment to salesforce
		if (isset($uploadAGB) && $uploadAGB) {
			// agb uploaded successfully, add information to salesforce ep
			// update
			$fields[DBConstants::DB_SIGNED_AGB] = DBConstants::SF_TRUE;
			$fields[DBConstants::DB_AGB_LAGUAGE] = "German";
			$fields[DBConstants::DB_AGB_VERSION] = "01.04.2012";
			$fields[DBConstants::DB_AGB_STATUS] = DBValues::$DB_VALUES_AGB_STATUS["review"];
			$fields[DBConstants::DB_DATE_AGB_SIGNED] = date('Y-m-d');
		}
		if (isset($uploadAN) && $uploadAN) {
			// agb uploaded successfully, add information to salesforce ep
			// update
			// $fields[DBConstants::DB_AGB_LAGUAGE] = ;
			// $fields[DBConstants::DB_AGB_VERSION] = ;
			$fields[DBConstants::DB_ACCEPTANCE_NOTE] = DBConstants::SF_TRUE;
			$fields[DBConstants::DB_AN_UPLOAD_DATE] = date('Y-m-d');
		}
		if (isset($uploadCertificateOfEnrollment) && $uploadCertificateOfEnrollment) {
			$fields[DBConstants::DB_ENROLLMENT_CERTIFICATE_UPLOADED] = DBConstants::SF_TRUE;
			$fields[DBConstants::DB_ENROLLMENT_CERTIFICATE_DATE] = date('Y-m-d');
		}
		if (isset($uploadExperienceReport) && $uploadExperienceReport) {
			$fields[DBConstants::DB_DATE_EXPERIENCE_REPORT_UPLOADED] = date('c');
		}
		
		if (count($fields) > 0)
			return DataServiceEP::updateEP($ep->getId(), $state, $fields, $sfConnection);
		else
			return DataService::SUCCESS;
	}

	public static function updateEPFromObject ($ep, $state, $sfConnection)
	{
		$fields = array(
				DBConstants::DB_EARLIEST_START_DATE => $ep->getEarliestStartDate()->format('F Y'),
				DBConstants::DB_LATEST_END_DATE => $ep->getLatestEndDate()->format('F Y'),
				DBConstants::DB_MINIMUM_DURATION => $ep->getMinimumDuration(),
				DBConstants::DB_MAXIMUM_DURATION => $ep->getMaximumDuration()
		);
		
		// delete all fields not allowed to be changed
		$fields = array_intersect_key($fields, array_flip(DBConstants::$modifyableFieldsEP[$state]));
		// remove null fields
		$fields = array_filter($fields, create_function('$field', 'return !($field===NULL);'));
		// implode multible choice fields and set date types to format
		// salesforce understands
		$fields = array_map(
				array(
						'AIESEC\Portal\DataBundle\Service\DataService',
						'databaseFieldsMapper'
				), $fields);
		// $fields = array_map(create_function('$value','return
		// DataService::databaseFieldsMapper($value);'),$fields);
		// $fields = array_map(DataService::databaseFieldsMapper,$fields);
		
		// do the actual database update
		// $fields will be tested for containing changable fields only even
		// though this functions already takes care of this!!!
		return DataServiceEP::updateEP($ep->getId(), $state, $fields, $sfConnection);
	}

	/**
	 * This function updates the values in <code>$fields</code> of
	 * the Salesforce 'EP' object referenced by $sId.</p>
	 * <b>$sId and $state is not checked here and HAS to be
	 * validated before</b></p>
	 * Securrity checks for $fields are present but might have to be
	 * moved somewhere else!
	 */
	public static function updateEP ($sId, $state, $fields, $sfConnection)
	{
		if (DataServiceEP::validateEPFields($fields, $state)) {
			$sObject = new \sObject();
			$sObject->type = DBConstants::TYPE_EP;
			$sObject->Id = $sId;
			$sObject->fields = $fields;
			
			// TODO: catch exceptions
			$response = $sfConnection->update(array(
					$sObject
			));
			
			return $response;
		} else {
			return DataService::QUERY_CONTAINED_ILLEGAL_FIELDS;
		}
	}

	private static function validateEPFields ($fields, $state)
	{
		$fieldsValid = true;
		
		// See explanation in validateAccountFields.
		// The only difference is that modifyableFieldsEP
		// is a multi-dimensional array
		foreach (array_keys($fields) as $field) {
			$fieldsValid &= ! (FALSE === array_search($field, DBConstants::$modifyableFieldsEP[$state]));
			if (! $fieldsValid)
				break;
		}
		
		return $fieldsValid;
	}
}

?>