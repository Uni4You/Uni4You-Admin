<?php

namespace FacultyInfo\FirstPartyDataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

class Mapmarker {
	private $id;
	private $name;
	private $description;
	private $latitude;
	private $longitude;
	
	private $category;
	

    /**
     * Set id
     *
     * @param string $id
     * @return Mapmarker
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
     * @return Mapmarker
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
     * Set description
     *
     * @param string $description
     * @return Mapmarker
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
     * Set latitude
     *
     * @param float $latitude
     * @return Mapmarker
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return Mapmarker
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set category
     *
     * @param \FacultyInfo\FirstPartyDataBundle\Entity\MapmarkerCategory $category
     * @return Mapmarker
     */
    public function setCategory(\FacultyInfo\FirstPartyDataBundle\Entity\MapmarkerCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \FacultyInfo\FirstPartyDataBundle\Entity\MapmarkerCategory 
     */
    public function getCategory()
    {
        return $this->category;
    }
}
