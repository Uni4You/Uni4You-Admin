<?php
namespace AIESEC\Portal\DataBundle\Entity;

class API_Object {
	protected $id;
	
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	protected static function formatToDateTime ($date)
	{
		if (is_string($date))
			return new \DateTime($date);
		else
		if (is_object($date) && $date instanceof \DateTime)
			return $date;
		return null;
	}
}