<?php

namespace CanalTP\IussaadCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Role
 */
class Role
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    protected $applications;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $roleParents;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $applicationRoles;
    
    /**
     * Constructor
     */
    public function __construct($applications = array())
    {
        $this->applicationRoles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->applications = $applications;
    }

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
     * @return Role
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
     * Add applicationRole
     *
     * @param \CanalTP\IussaadCoreBundle\Entity\ApplicationRole $applicationRole
     * @return Role
     */
    public function addApplicationRole(\CanalTP\IussaadCoreBundle\Entity\ApplicationRole $applicationRole)
    {
        $this->applicationRoles[] = $applicationRole;
    
        return $this;
    }

    /**
     * Remove applicationRole
     *
     * @param \CanalTP\IussaadCoreBundle\Entity\ApplicationRole $applicationRole
     */
    public function removeApplicationRole(\CanalTP\IussaadCoreBundle\Entity\ApplicationRole $applicationRole)
    {
        $this->applicationRoles->removeElement($applicationRole);
    }

    /**
     * Get applicationRoles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getApplicationRoles()
    {
        return $this->applicationRoles;
    }

    /**
     * Add roleParent
     *
     * @param \CanalTP\IussaadCoreBundle\Entity\ApplicationRole $roleParent
     * @return Role
     */
    public function addRoleParent(\CanalTP\IussaadCoreBundle\Entity\ApplicationRole $roleParent)
    {
        $this->roleParents[] = $roleParent;
    
        return $this;
    }

    /**
     * Remove roleParent
     *
     * @param \CanalTP\IussaadCoreBundle\Entity\ApplicationRole $roleParent
     */
    public function removeRoleParent(\CanalTP\IussaadCoreBundle\Entity\ApplicationRole $roleParent)
    {
        $this->roleParents->removeElement($roleParent);
    }

    /**
     * Get roleParents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRoleParents()
    {
        return $this->roleParents;
    }
    
    /**
     * @param string $application
     *
     * @return Role
     */
    public function addApplication($application)
    {
        if (!$this->hasApplication($application)) {
            $this->applications[] = $application;
        }

        return $this;
    }

    /**
     * @param string $application
     */
    public function hasApplication($application)
    {
        return in_array($application, $this->applications, true);
    }

    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * @param string $application
     *
     * @return Role
     */
    public function removeApplication($application)
    {
        if (false !== $key = array_search($application, $this->applications, true)) {
            unset($this->applications[$key]);
            $this->applications = array_values($this->applications);
        }

        return $this;
    }

    /**
     * @param array $applications
     *
     * @return Role
     */
    public function setApplications(array $applications)
    {
        $this->applications = $applications;

        return $this;
    }
    
}
