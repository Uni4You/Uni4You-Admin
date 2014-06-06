<?php
namespace AIESEC\Portal\DataBundle\Entity;

class Attachment {
	public $id;
	public $body;
	public $creationDate;
	public $name;
	public $description;
	public $size;
	
	public function __construct($id, $name, $description, $size, $creationDate, $body=null){
		$this->id = $id;
		$this->name = $name;
		$this->description = $description;
		$this->size = $size;
		$this->creationDate = $creationDate;
		$this->body = $body;
	}
	
	public function getSizeAsString($precision = 2) { 
		$units = array('B', 'KB', 'MB', 'GB', 'TB'); 

		$pow = floor(($this->size ? log($this->size) : 0) / log(1024)); 
		$pow = min($pow, count($units) - 1); 

		// Uncomment one of the following alternatives
		$bytes = $this->size / pow(1024, $pow);
		// $bytes /= (1 << (10 * $pow)); 

		return round($bytes, $precision) . ' ' . $units[$pow]; 
	}
}
?>