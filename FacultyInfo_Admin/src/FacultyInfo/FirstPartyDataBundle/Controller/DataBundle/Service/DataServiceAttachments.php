<?php
namespace AIESEC\Portal\DataBundle\Service;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use AIESEC\Portal\DataBundle\Entity\Attachment;
use Symfony\Component\DependencyInjection\ContainerAware;


class DataServiceAttachments
{
	private static function isAttachmentPublic($attachment){
		$description = htmlentities($attachment->description);
	
		// checking if description field begins with characteristic
		// value given during upload in case this platform was used.
		return array_reduce(DBValues::$PUBLIC_ATTACHMENTS_DESCRIPTION,
			function($res,$current) use ($description){
				return $res || is_int(stripos($description,$current));
			}, false);
		//http://localhost/AIESEC1.1/web/app_dev.php/en/profile/attachments/00P2000000QHfYZEA1
	}

	public static function getAttachmentInformation($parentId,$sfConnection){
		$query = "SELECT ID, Name, Description, BodyLength, CreatedDate from Attachment where ParentId='$parentId'";
		$queryResult = $sfConnection->query($query);
		$records = $queryResult->records;
		
		$attachments = array();
		foreach($records as $record){
			$attSObject = new \SObject($record);
			$id = $attSObject->Id;
			$name = $attSObject->fields->Name;
			$description = $attSObject->fields->Description;
			$size = $attSObject->fields->BodyLength;
			$creationDate = $attSObject->fields->CreatedDate;
			
			$attachment = new Attachment($id, $name, $description, $size, $creationDate);
			if(self::isAttachmentPublic($attachment)){
				$attachments[] = $attachment;
			}
		}
		
		return $attachments;
	}
	
	public static function downloadAttachment($id, $parentId,$sfConnection){
		$query = "SELECT ID, Name, Description, BodyLength, CreatedDate, ParentId, Body, ContentType from Attachment where ID='$id'";
		$queryResult = $sfConnection->query($query);
		$records = $queryResult->records;
		
		if($records === null || count($records) == 0){
			return DataService::NO_ENTRIES_FOUND;
		}
		
		$attachments = array();
		$attSObject = new \SObject($records[0]);

		if($parentId !== $attSObject->fields->ParentId)
			return DataService::INVALID_OBJECT_ACCESSED;
		
		$id = $attSObject->Id;
		$name = $attSObject->fields->Name;
		$description = $attSObject->fields->Description;
		$size = $attSObject->fields->BodyLength;
		$creationDate = $attSObject->fields->CreatedDate;
		$body = $attSObject->fields->Body;
		
		$attachment = new Attachment($id, $name, $description, $size, $creationDate, $body);
		
		return (self::isAttachmentPublic($attachment)? $attachment:DataService::ATTACHMENT_NOT_PUBLIC);
	}
}
?>