<?php
namespace AIESEC\Portal\DataBundle\Entity;
use AIESEC\Portal\DataBundle\Service;

/**
 * 
 * @author Felix Goroncy
 *
 * 2014/05/16 - created
 */
class Timeslot{
	
	private $id;
	
	/** In case booked/open timeslots are displayed the timeslot owner has
	 * to be saved in this property (without deep information. That is
	 * no jobs and timeslots have to be queried). */
	private $account;
	
	/** As strange as it sounds, this field
	 * will hold the topic of the booked slot.
	 * That is, it will be filled in by the
	 * booking person. E.g.: PDT */
	private $slotName;
	/** Will hold the date and time of the
	 * beginning of the slot */
	private $start;
	/** Duration of the Timeslot (broken hours)*/
	private $duration;
	/**	Is this Timeslot still available? Calculated, true if "Booked by" is null */
// 	private $available;
	/** salesforce id of account object that booked the slot in case person diplaying it
	 * is the booker. In case you look at timeslots of your own that others booked the
	 * information about the booker must be stored (shallow object -> no job / timeslot info).*/
	private $bookedBy;
	/** type of booking. Filled in by booking person. */
	private $type;
	/**	Short Description of Reason for Booking */
	private $summary;
	/** Description/Comment on Reasons for Booking */
	private $comment;
	
	
	//contact information for both bookee and booker
	private $ownerName;
	private $ownerEmail;
	private $ownerSkype;
	private $ownerPhone;
	
	private $bookerName;
	private $bookerEmail;
	private $bookerSkype;
	private $bookerPhone;
	
	/**
	 * Conversion function for all time based properties.
	 * TODO: outsource to central location to use single
	 * function for all entity objects!
	 * 
	 * @param mixed $date
	 * @return \DateTime|NULL
	 */
	private function formatToDateTime ($date)
	{
		if (is_string($date))
			return new \DateTime($date);
		else
		if (is_object($date) && $date instanceof \DateTime)
			return $date;
		return null;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	public function getId(){
		return $this->id;
	}
	
	public function setAccount($account){
		$this->account = $account;
	}
	public function getAccount(){
		return $this->account;
	}
	
	public function setSlotName($slotName){
		if(is_null($slotName) || is_string($slotName))
			$this->slotName = $slotName;
	}
	public function getSlotName(){
		return $this->slotName;
	}
	
	public function setStart($start){
		$this->start = self::formatToDateTime($start);
	}
	public function getStart(){
		return $this->start;
	}
	
	public function setDuration($duration){
		if(is_float($duration) || is_null($duration))
			$this->duration = $duration;
		if(is_string($duration))
			$this->duration = floatval($duration);

	}
	public function getDuration(){
		return $this->duration;
	}

	public function isAvailable(){
		return is_null($this->bookedBy);
	}
	
	public function setBookedBy($bookedBy){
		//TODO: parameter validation
		$this->bookedBy = $bookedBy;
	}
	public function getBookedBy(){
		return $this->bookedBy;
	}
	
	public function setType($type){
		if(is_int($type))
			$this->type = $type;
	}
	public function getType(){
		return $this->type;
	}
	
	public function setSummary($summary){
		if(is_null($summary) || is_string($summary))
			$this->summary = $summary;
	}
	public function getSummary(){
		return $this->summary;
	}
	
	public function setComment($comment){
		if(is_null($comment) || is_string($comment))
			$this->comment = $comment;
	}
	public function getComment(){
		return $this->comment;
	}
	
	public function setOwnerName($name){
		if(is_null($name) || is_string($name))
			$this->ownerName = $name;
	}
	public function getOwnerName(){
		return $this->ownerName;
	}
	
	public function setOwnerEmail($email){
		$this->ownerEmail = $email;
	}
	public function getOwnerEmail(){
		return $this->ownerEmail;
	}
	
	public function setOwnerSkype($skype){
		$this->ownerSkype = $skype;
	}
	public function getOwnerSkype(){
		return $this->ownerSkype;
	}
	
	public function setOwnerPhone($phone){
		$this->ownerPhone = $phone;
	}
	public function getOwnerPhone(){
		return $this->ownerPhone;
	}
	
	public function setBookerName($name){
		if(is_null($name) || is_string($name))
			$this->bookerName = $name;
	}
	public function getBookerName(){
		return $this->bookerName;
	}
	
	public function setBookerEmail($email){
		$this->bookerEmail = $email;
	}
	public function getBookerEmail(){
		return $this->bookerEmail;
	}
	
	public function setBookerSkype($skype){
		$this->bookerSkype = $skype;
	}
	public function getBookerSkype(){
		return $this->bookerSkype;
	}
	
	public function setBookerPhone($phone){
		$this->bookerPhone = $phone;
	}
	public function getBookerPhone(){
		return $this->bookerPhone;
	}
	
}