<?php
namespace AIESEC\Portal\DataBundle\Service;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use AIESEC\Portal\DataBundle\Entity\EP;
use AIESEC\Portal\DataBundle\Entity\Account;
use Symfony\Component\DependencyInjection\ContainerAware;


class DataService extends ContainerAware
{
	const FLAG_JOBS = 1;
	const FLAG_TIMESLOTS = 2;
	const FLAG_CONFERENCES = 4;
	const FLAG_PDTS = 8;
	const FLAG_GOAL = 16;
	
	const SUCCESS = 0;
	const FILE_TOO_BIG = 1;
	const ATTACHMENTS_COULD_NOT_UPLOAD = 2;
	const QUERY_CONTAINED_ILLEGAL_FIELDS = 3;
	const COULD_NOT_UPDATE_OBJECT = 4;
	const EP_ID_NOT_VALID = 5;
	const NO_FILES_UPLOADED = 6;
	const PASSWORDS_DID_NOT_MATCH = 7;
	const OLD_PASSWORD_INCORECT = 8;
	const HASH_NOT_SECURE_ENOUGH = 9;
	const PARENT_ID_CONTAINS_INVALID_CHARACTERS = 10;
	const COULD_NOT_UPLOAD_ALL_LANGUAGE_CERTIFICATES = 11;
	const NO_ENTRIES_FOUND = 12;
	const INVALID_OBJECT_ACCESSED = 13;
	const ATTACHMENT_NOT_PUBLIC = 14;

	private $sfConnection;
	private $sfLogger;

	function __construct ()
	{
		$this->sfConnection = null;
	}
	
	protected function getSFConnection ()
	{
		if ($this->sfConnection == null) {
			$username = $this->container->getParameter('sf_username'.$this->container->getParameter('envir_suffix'));
			$password = $this->container->getParameter('sf_password'.$this->container->getParameter('envir_suffix'));
			$token = $this->container->getParameter('sf_token'.$this->container->getParameter('envir_suffix'));
			$wsdl = $this->container->getParameter('sf_wsdl'.$this->container->getParameter('envir_suffix'));

			$this->sfConnection = new \SforcePartnerClient();
			$this->sfConnection->createConnection(
					$this->container->get('kernel')
					->getRootDir() . '/config/' . $wsdl);
			$this->sfConnection->login($username,$password.$token);
		}

// 		print_r($this->sfConnection->describeSObject(self::TYPE_ACCOUNT));

		return $this->sfConnection;
	}

	public function getAccountById ($id, $flags=0)
	{
		if (! ctype_alnum($id))
			throw new Exception('Invalid Account Id!');

		return DataServiceAccount::getAccount('Id', $id, $this->getSFConnection(),$flags);
	}

	public function getAccountByEmail ($email, $flags=0)
	{
		return DataServiceAccount::getAccount('PersonEmail', $email, $this->getSFConnection(),$flags);
	}

	/**
	 * Function returns a single EP from the database.
	 * @param $epId Id of the EP object inside database.
	 * 	An additional test if $epId is actually part of
	 * 	current users ep ids <b>IS</b> performed.
	 * @return instance of EP or null
	 */
	public function getEPById($epId){
		if($this->container->get('security.context')->getToken()->getUser()->isEPIdValid($epId)){
			return DataServiceEP::getEP(DBConstants::DB_EP_ID,$epId,$this->getSFConnection());
		}else{
			//TODO: REPORT THIS!!!
			throw new \Exception('Invalid EP id passed in!!');
		}
	}

	public function getICCs(){
		return DataServiceICC::getICCs($this->getSFConnection());
	}
	
	public function getAttachmentInformation($parentId){
		return DataServiceAttachments::getAttachmentInformation($parentId,$this->getSFConnection());
	}
	
	public function downloadAttachment($id, $parentId){
		$result = DataServiceAttachments::downloadAttachment($id,$parentId, $this->getSFConnection());
		if(is_int($result))
			return $this->validateResult($result);
		
		return $result;
	}

	public function insertLeadGlobalCitizen($lead){
		$result = DataServiceLeads::insertLeadGlobalCitizen($lead,$this->getSFConnection());
		
		return $this->validateResult($result);
	}
	
	public function getLead(){
		return DataServiceLeads::getLead($this->getSFConnection());
	}
	

	//====================== writing to database ========================
	public function validateResult($result){
		if(is_int($result)){
			if($result != self::SUCCESS){
				$this->container->get("monolog.logger.salesforce")->error("Error Code: $result for ".
						$this->container->get('security.context')->getToken()->getUser()->getEmail());
				if($result == self::NO_FILES_UPLOADED){
					$this->container->get('session')->getFlashBag()->add(
						'error',$this->container->get('translator')
							->trans('DataService.error.noFilesUploaded')
					);
				}else{
					//$this->container->get('session')->getFlashBag()->add(
						//'error','Internal Error!! '.$result
						//$this->get('translator')->trans('form.saveSuccessful')
					//);
				}
			}else{ return true;}
		}else if(is_array($result)){
			if($result[0]->success){
				return true;
			}else{
				ob_start();
				var_dump($result);
				$resultAsString = ob_get_clean();
				$this->container->get("monolog.logger.salesforce")->error("Error: $resultAsString for ".
						$this->container->get('security.context')->getToken()->getUser()->getEmail());
// 				$this->container->get('session')->getFlashBag()->add(
// 					'error','Internal Error!!'
// 					//$this->get('translator')->trans('form.saveSuccessful')
// 				);
			}
		}else{
				ob_start();
				var_dump($result);
				$resultAsString = ob_get_clean();
				$this->container->get("monolog.logger.salesforce")->error("Error: $resultAsString for ".
						$this->container->get('security.context')->getToken()->getUser()->getEmail());
// 			$this->container->get('session')->getFlashBag()->add(
// 				'error','Internal Error!! Result value neither int nor Object'
// 				//$this->get('translator')->trans('form.saveSuccessful')
// 			);
		}
		
		return false;
	}
	
	public function changePassword($newPassword,$oldPassword){
		$user = $this->container->get('security.context')->getToken()->getUser();
		$encoder = $this->container->get('aiesec_portal_security_custom_encoder');
		$oldEncoded = $encoder->encodePassword($oldPassword,$user->getSalt());
		
		if($user->getPassword === $oldEncoded)
		{
			return $this->resetPassword($newPassword);
		}else{
			return $this->validateResult(self::OLD_PASSWORD_INCORECT);
		}
	}
	
	public function setPasswordResetHash($id,$hash){
		if(strlen($hash) < 5)
			return $this->validateResult(self::HASH_NOT_SECURE_ENOUGH);
		
		$fields = array(
			DBConstants::DB_PASSWORD_RESET_HASH=>$hash,
			DBConstants::DB_PASSWORD_RESET_HASH_DATE=>date('c'),
		);
		$result = DataServiceAccount::updateAccount($id,
			$fields, $this->getSFConnection());

		return $this->validateResult($result);
	}
	
	public function resetPassword($newPassword,$id=null){
		if($id == null){
			$user = $this->container->get('security.context')->getToken()
				->getUser();
			$id = $user->getAccountId();
		}
			
		$salt = $this->container->getParameter('security_salt');
		$encoder = $this->container->get('aiesec_portal_security_custom_encoder');

		$pwEncoded = $encoder->encodePassword($newPassword,$salt);
			
		$fields = array(
			DBConstants::DB_PASSWORD=>$pwEncoded,
			DBConstants::DB_PASSWORD_RESET_NEEDED=>DBConstants::SF_FALSE,
			DBConstants::DB_PASSWORD_RESET_HASH_DATE=>'1999-12-12T12:00:00.000Z',
		);
		$result = DataServiceAccount::updateAccount($id,
			$fields, $this->getSFConnection());

		$result = $this->validateResult($result);
		if($result && isset($user)){
			//update current session instance
			$user->setPassword($pwEncoded);
			$user->setPasswortResetRequired(false);
		}
		
		return $result;
	}

	public function updateAccountFromObject($account){
		$result = DataServiceAccount::
			updateAccountFromObject($account, $this->getSFConnection());
		return $this->validateResult($result);
	}
	
	public function updateBankDataFromObject($account){
		return DataServiceAccount::
			updateBankDataFromObject($account, $this->getSFConnection());
		return $this->validateResult($result);
	}
	
	public function updateEPFromObject($ep){
// 		$epIds = $this->getUser()->getEPIds();
		$epIds = $this->container->get('security.context')->getToken()->getUser()->getEPIds();
		if(key_exists($ep->getId(), $epIds)){
			$result = DataServiceEP::
				updateEPFromObject($ep, $epIds[$ep->getId()], $this->getSFConnection());
		}else{
			$result = self::EP_ID_NOT_VALID;
		}
		
		return $this->validateResult($result);
	}
	
	public function updateEPContractsFromObject($ep){
		$user = $this->container->get('security.context')->getToken()
			->getUser();
		if($user->isEPIdValid($ep->getId())){
			$epIds = $user->getEPIds();
			$result = DataServiceEP::
				updateEPContractsFromObject($ep, $epIds[$ep->getId()], $this->getSFConnection());
		}else{
			$result = self::EP_ID_NOT_VALID;
		}
		
		return $this->validateResult($result);
	}

	public static function databaseFieldsMapper($value){
		if(is_string($value)){
			return str_replace("&","",$value);
		}if(is_array($value)){
			if(count($value)==0)
				return null;
			return str_replace("&","",implode(";",$value));
		}else if($value instanceof \DateTime)
			return $value->format("Y-m-d\\TH:i:s\\Z");
		else if(is_bool($value))
			return ($value? DBConstants::SF_TRUE : DBConstants::SF_FALSE);
		else return $value;
	}
//==================== end writing to database ======================
}
