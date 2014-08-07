<?php

namespace CanalTP\SamCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 */
class Client
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $logoPath;

    /**
     * @var string
     */
    protected $nameCanonical;

    /**
     * @var boolean
     */
    protected $locked;

    /**
     * @var \DateTime
     */
    protected $creationDateTime;

    /**
     * @var \DateTime
     */
    protected $lastModificationDateTime;

    /**
     * @var string
     */
    protected $navitiaToken;
    
    /**
     *
     * @var Application
     */
    protected $applications;
    
    protected $users;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Client
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
     * Set logoPath
     *
     * @param string $logoPath
     * @return Client
     */
    public function setLogoPath($logoPath)
    {
        $this->logoPath = $logoPath;

        return $this;
    }

    /**
     * Get logoPath
     *
     * @return string 
     */
    public function getLogoPath()
    {
        return $this->logoPath;
    }

    /**
     * Set nameCanonical
     *
     * @param string $nameCanonical
     * @return Client
     */
    public function setNameCanonical($nameCanonical)
    {
        $this->nameCanonical = $nameCanonical;

        return $this;
    }

    /**
     * Get nameCanonical
     *
     * @return string 
     */
    public function getNameCanonical()
    {
        return $this->nameCanonical;
    }

    /**
     * Set locked
     *
     * @param boolean $locked
     * @return Client
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * Get locked
     *
     * @return boolean 
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Set creationDateTime
     *
     * @param \DateTime $creationDateTime
     * @return Client
     */
    public function setCreationDateTime($creationDateTime)
    {
        $this->creationDateTime = $creationDateTime;

        return $this;
    }

    /**
     * Get creationDateTime
     *
     * @return \DateTime 
     */
    public function getCreationDateTime()
    {
        return $this->creationDateTime;
    }

    /**
     * Set lastModificationDateTime
     *
     * @param \DateTime $lastModificationDateTime
     * @return Client
     */
    public function setLastModificationDateTime($lastModificationDateTime)
    {
        $this->lastModificationDateTime = $lastModificationDateTime;

        return $this;
    }

    /**
     * Get lastModificationDateTime
     *
     * @return \DateTime 
     */
    public function getLastModificationDateTime()
    {
        return $this->lastModificationDateTime;
    }
    
    public function setNavitiaToken($navitiaToken) 
    {
        $this->navitiaToken = $navitiaToken;
        
        return $this;
    }
    
    public function getNavitiaToken() 
    {
        return $this->navitiaToken;
    }
    
    public function setApplications($applications) 
    {
        $this->applications = $applications;
        
        return $this;
    }
    
    public function getApplications() 
    {
        return $this->applications;
    }
    
    public function setUsers($users) 
    {
        $this->users = $users;
        
        return $this;
    }
    
    public function getUsers() 
    {
        return $this->users;
    }
}
