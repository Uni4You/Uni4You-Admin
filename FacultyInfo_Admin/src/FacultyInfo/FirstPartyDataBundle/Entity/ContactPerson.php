<?php

namespace FacultyInfo\FirstPartyDataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

class ContactPerson {
	private $id;
	private $name;
	private $description;
	private $office;
	private $phone;
	private $email;
	private $latitude;
	
	private $group;
	

    /**
     * Set id
     *
     * @param string $id
     * @return ContactPerson
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ContactPerson
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set office
     *
     * @param string $office
     * @return ContactPerson
     */
    public function setOffice($office)
    {
        $this->office = $office;

        return $this;
    }

    /**
     * Get office
     *
     * @return string 
     */
    public function getOffice()
    {
        return $this->office;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return ContactPerson
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return ContactPerson
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return ContactPerson
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set group
     *
     * @param \FacultyInfo\FirstPartyDataBundle\Entity\ContactGroup $group
     * @return ContactPerson
     */
    public function setGroup(\FacultyInfo\FirstPartyDataBundle\Entity\ContactGroup $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \FacultyInfo\FirstPartyDataBundle\Entity\ContactGroup 
     */
    public function getGroup()
    {
        return $this->group;
    }
}
