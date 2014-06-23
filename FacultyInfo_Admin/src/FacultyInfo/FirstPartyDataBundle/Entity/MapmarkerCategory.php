<?php

namespace FacultyInfo\FirstPartyDataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

class MapmarkerCategory {
	private $id;
	private $title;
	private $subCategories;
	private $mapmarkers;
	private $timestamp;
	
	private $superCategory;
	
	public function __construct() {
		$this->subCategories = new ArrayCollection();
		$this->mapmarkers = new ArrayCollection();
	}


    /**
     * Set id
     *
     * @param string $id
     * @return MapmarkerCategory
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
     * Set title
     *
     * @param string $title
     * @return MapmarkerCategory
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }
	
	

    /**
     * Add subCategories
     *
     * @param \FacultyInfo\FirstPartyDataBundle\Entity\MapmarkerCategory $subCategories
     * @return MapmarkerCategory
     */
    public function addSubCategory(\FacultyInfo\FirstPartyDataBundle\Entity\MapmarkerCategory $subCategories)
    {
        $this->subCategories[] = $subCategories;

        return $this;
    }

    /**
     * Remove subCategories
     *
     * @param \FacultyInfo\FirstPartyDataBundle\Entity\MapmarkerCategory $subCategories
     */
    public function removeSubCategory(\FacultyInfo\FirstPartyDataBundle\Entity\MapmarkerCategory $subCategories)
    {
        $this->subCategories->removeElement($subCategories);
    }

    /**
     * Get subCategories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubCategories()
    {
        return $this->subCategories;
    }

    /**
     * Add mapmarkers
     *
     * @param \FacultyInfo\FirstPartyDataBundle\Entity\Mapmarker $mapmarkers
     * @return MapmarkerCategory
     */
    public function addMapmarker(\FacultyInfo\FirstPartyDataBundle\Entity\Mapmarker $mapmarkers)
    {
        $this->mapmarkers[] = $mapmarkers;

        return $this;
    }

    /**
     * Remove mapmarkers
     *
     * @param \FacultyInfo\FirstPartyDataBundle\Entity\Mapmarker $mapmarkers
     */
    public function removeMapmarker(\FacultyInfo\FirstPartyDataBundle\Entity\Mapmarker $mapmarkers)
    {
        $this->mapmarkers->removeElement($mapmarkers);
    }

    /**
     * Get mapmarkers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMapmarkers()
    {
        return $this->mapmarkers;
    }

    /**
     * Set superCategory
     *
     * @param \FacultyInfo\FirstPartyDataBundle\Entity\MapmarkerCategory $superCategory
     * @return MapmarkerCategory
     */
    public function setSuperCategory(\FacultyInfo\FirstPartyDataBundle\Entity\MapmarkerCategory $superCategory = null)
    {
        $this->superCategory = $superCategory;

        return $this;
    }

    /**
     * Get superCategory
     *
     * @return \FacultyInfo\FirstPartyDataBundle\Entity\MapmarkerCategory 
     */
    public function getSuperCategory()
    {
        return $this->superCategory;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return MapmarkerCategory
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime 
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
}
