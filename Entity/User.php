<?php

/**
 * Description of class UserSim
 *
 * @author akambi
 */

namespace CanalTP\IussaadCoreBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="t_user")
 */
class User extends BaseUser
{
    const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $firstname;

    /**
     * @var string
     */
    protected $lastname;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $groups;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $roleGroupByApplications;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $applicationRoles;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->applicationRoles = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set firstname
     *
     * @param  string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param  string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Add applicationRoles
     *
     * @param \CanalTP\IussaadCoreBundle\Entity\ApplicationRole $applicationRoles
     * @return User
     */
    public function addApplicationRole(\CanalTP\IussaadCoreBundle\Entity\ApplicationRole $applicationRoles)
    {
        $this->applicationRoles[] = $applicationRoles;
    
        return $this;
    }

    /**
     * Remove applicationRoles
     *
     * @param \CanalTP\IussaadCoreBundle\Entity\ApplicationRole $applicationRoles
     */
    public function removeApplicationRole(\CanalTP\IussaadCoreBundle\Entity\ApplicationRole $applicationRoles)
    {
        $this->applicationRoles->removeElement($applicationRoles);
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
     * Set currentApplicationRoles
     *
     * @return Role 
     */
    public function setApplicationRoles($applicationRoles)
    {
        $this->applicationRoles = $applicationRoles;

        return ($this);
    }

    /**
     * Get currentApplicationRoles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCurrentApplicationRoles()
    {
        $currentApplicationRoles = new \Doctrine\Common\Collections\ArrayCollection();

        foreach ($this->applicationRoles as $applicationRole) {
            // TODO: 3 is Id of MTT application (current)
            if ($applicationRole->getApplication()->getId() == 3)
                $currentApplicationRoles[] = $applicationRole;
        }
        return ($currentApplicationRoles);
    }

    /**
     * Set currentApplicationRoles
     *
     * @return Role 
     */
    public function setCurrentApplicationRoles($currentApplicationRoles)
    {
        $this->currentApplicationRoles = $currentApplicationRoles;

        return ($this);
    }


    /**
     * Add roleGroupByApplication
     *
     * @param \CanalTP\IussaadCoreBundle\Entity\ApplicationRole $roleParent
     * @return Role
     */
    public function addRoleGroupByApplication(\CanalTP\IussaadCoreBundle\Entity\ApplicationRole $roleGroupByApplication)
    {
        $this->roleGroupByApplications[] = $roleGroupByApplication;
    
        return $this;
    }

    /**
     * Remove roleGroupByApplication
     *
     * @param \CanalTP\IussaadCoreBundle\Entity\Application $roleParent
     */
    public function removeRoleGroupByApplication(\CanalTP\IussaadCoreBundle\Entity\ApplicationRole $roleGroupByApplication)
    {
        $this->roleGroupByApplications->removeElement($roleGroupByApplication);
    }

    /**
     * Get roleGroupByApplications
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRoleGroupByApplications()
    {
        return $this->roleGroupByApplications;
    }    
    
    /**
     * Returns the user roles
     *
     * @return array The roles
     */
    public function getRoles()
    {
        $roles = $this->roles;

        // we need to make sure to have at least one role
        $roles[] = static::ROLE_DEFAULT;

        return array_unique($roles);
    }
    
    /**
     * Appeler avant la mise à jour d'un objet en base de donnée
     */
    public function onPostLoad()
    {
        $aRoles = array();
        foreach ($this->getApplicationRoles() as $applicationRole) {
            $aRoles[] = $applicationRole->getCanonicalRole();
        }
        $this->setRoles($aRoles);
    }    
}