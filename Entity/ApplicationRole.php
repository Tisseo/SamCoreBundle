<?php

namespace CanalTP\IussaadCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ApplicationRole
 */
class ApplicationRole
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
     * @var string
     */
    private $canonicalRole;
    
    /**
     * @var \CanalTP\IussaadCoreBundle\Entity\Application
     */
    private $application;

    /**
     * @var \CanalTP\IussaadCoreBundle\Entity\Role
     */
    private $role;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $children;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $parents;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $users;
    
    protected $currentRole;
    protected $parentRoles;
    
    /**
     * Constructor
     */
    public function __construct($parentRoles = array())
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        $this->parents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->parentRoles = $parentRoles;
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
     * Set canonicalRole
     *
     * @param string $canonicalRole
     * @return Role
     */
    public function setCanonicalRole($canonicalRole)
    {
        $this->canonicalRole = $canonicalRole;
    
        return $this;
    }

    /**
     * Get canonicalRole
     *
     * @return string 
     */
    public function getCanonicalRole()
    {
        return $this->canonicalRole;
    }
    
    /**
     * Set application
     *
     * @param \CanalTP\IussaadCoreBundle\Entity\Application $application
     * @return ApplicationRole
     */
    public function setApplication(\CanalTP\IussaadCoreBundle\Entity\Application $application = null)
    {
        $this->application = $application;
    
        return $this;
    }

    /**
     * Get application
     *
     * @return \CanalTP\IussaadCoreBundle\Entity\Application 
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Set role
     *
     * @param \CanalTP\IussaadCoreBundle\Entity\Role $role
     * @return ApplicationRole
     */
    public function setRole(\CanalTP\IussaadCoreBundle\Entity\Role $role = null)
    {
        $this->role = $role;
    
        return $this;
    }

    /**
     * Get role
     *
     * @return \CanalTP\IussaadCoreBundle\Entity\Role 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Add children
     *
     * @param \CanalTP\IussaadCoreBundle\Entity\ApplicationRole $children
     * @return ApplicationRole
     */
    public function addChildren(\CanalTP\IussaadCoreBundle\Entity\ApplicationRole $children)
    {
        $this->children[] = $children;
    
        return $this;
    }

    /**
     * Remove children
     *
     * @param \CanalTP\IussaadCoreBundle\Entity\ApplicationRole $children
     */
    public function removeChildren(\CanalTP\IussaadCoreBundle\Entity\ApplicationRole $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Add parents
     *
     * @param \CanalTP\IussaadCoreBundle\Entity\ApplicationRole $parents
     * @return ApplicationRole
     */
    public function addParent(\CanalTP\IussaadCoreBundle\Entity\ApplicationRole $parents)
    {
        $this->parents[] = $parents;
    
        return $this;
    }

    /**
     * Remove parents
     *
     * @param \CanalTP\IussaadCoreBundle\Entity\ApplicationRole $parents
     */
    public function removeParent(\CanalTP\IussaadCoreBundle\Entity\ApplicationRole $parents)
    {
        $this->parents->removeElement($parents);
    }

    /**
     * Get parents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getParents()
    {
        return $this->parents;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $parents
     *
     * @return ApplicationRole
     */
    public function setParents(\Doctrine\Common\Collections\Collection $parents)
    {
        $this->parents = $parents;

        return $this;
    }
    
    /**
     * @param string $parentRole
     *
     * @return ApplicationRole
     */
    public function addParentRole($parentRole)
    {
        if (!$this->hasParentRole($parentRole)) {
            $this->parentRoles[] = $parentRole;
        }

        return $this;
    }

    /**
     * @param string $parentRole
     */
    public function hasParentRole($parentRole)
    {
        return in_array($parentRole, $this->parentRoles, true);
    }

    public function getParentRoles()
    {
        return $this->parentRoles;
    }

    /**
     * @param string $parentRole
     *
     * @return ApplicationRole
     */
    public function removeParentRole($parentRole)
    {
        if (false !== $key = array_search($parentRole, $this->parentRoles, true)) {
            unset($this->parentRoles[$key]);
            $this->parentRoles = array_values($this->parentRoles);
        }

        return $this;
    }

    /**
     * @param array $parentRoles
     *
     * @return ApplicationRole
     */
    public function setParentRoles(array $parentRoles)
    {
        $this->parentRoles = $parentRoles;

        return $this;
    }

    /**
     * Set currentRole
     *
     * @param \CanalTP\IussaadCoreBundle\Entity\Role $currentRole
     * @return ApplicationRole
     */
    public function setCurrentRole(\CanalTP\IussaadCoreBundle\Entity\Role $currentRole = null)
    {
        $this->currentRole = $currentRole;
    
        return $this;
    }

    /**
     * Get currentRole
     *
     * @return \CanalTP\IussaadCoreBundle\Entity\Role 
     */
    public function getCurrentRole()
    {
        return $this->currentRole;
    }
    
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Add users
     *
     * @param \CanalTP\IussaadCoreBundle\Entity\User $users
     * @return ApplicationRole
     */
    public function addUser(\CanalTP\IussaadCoreBundle\Entity\User $users)
    {
        $this->users[] = $users;
    
        return $this;
    }

    /**
     * Remove users
     *
     * @param \CanalTP\IussaadCoreBundle\Entity\User $users
     */
    public function removeUser(\CanalTP\IussaadCoreBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
}