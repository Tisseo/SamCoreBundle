<?php

namespace CanalTP\SamCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserApplicationRole
 */
class UserApplicationRole
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \CanalTP\SamEcoreUserManagerBundle\Entity\User
     */
    private $user;

    /**
     * @var \CanalTP\SamCoreBundle\Entity\Application
     */
    private $application;

    /**
     * @var \CanalTP\SamCoreBundle\Entity\Role
     */
    private $role;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    // private $children;

    /**
     * @var ApplicationRole
     */
    //private $parent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    //private $users;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    // private $parents;

    // protected $currentRole;
    // protected $parentRoles;

    // private $perimeters;

    /**
     * Constructor
     */
    public function __construct($parentRoles = array())
    {
        //$this->users = new \Doctrine\Common\Collections\ArrayCollection();

        //$this->parentRoles = $parentRoles;
        //$this->parents = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set application
     *
     * @param \CanalTP\SamCoreBundle\Entity\Application $application
     * @return ApplicationRole
     */
    public function setApplication(\CanalTP\SamCoreBundle\Entity\Application $application = null)
    {
        $this->application = $application;

        return $this;
    }

    /**
     * Get application
     *
     * @return \CanalTP\SamCoreBundle\Entity\Application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Set role
     *
     * @param \CanalTP\SamCoreBundle\Entity\Role $role
     * @return ApplicationRole
     */
    public function setRole(\CanalTP\SamCoreBundle\Entity\Role $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \CanalTP\SamCoreBundle\Entity\Role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Get parent
     *
     * @return ApplicationRole
     */
    // public function getParent()
    // {
    //     return $this->parent;
    // }

    /**
     * @param ApplicationRole $parent
     *
     * @return ApplicationRole
     */
    // public function setParent(ApplicationRole $parent)
    // {
    //     $this->parent = $parent;

    //     return $this;
    // }

    /**
     * @param string $parentRole
     *
     * @return ApplicationRole
     */
    // public function addParentRole($parentRole)
    // {
    //     if (!$this->hasParentRole($parentRole)) {
    //         $this->parentRoles[] = $parentRole;
    //     }

    //     return $this;
    // }

    /**
     * @param string $parentRole
     */
    // public function hasParentRole($parentRole)
    // {
    //     return in_array($parentRole, $this->parentRoles, true);
    // }

    // public function getParentRoles()
    // {
    //     return $this->parentRoles;
    // }

    /**
     * @param string $parentRole
     *
     * @return ApplicationRole
     */
    // public function removeParentRole($parentRole)
    // {
    //     if (false !== $key = array_search($parentRole, $this->parentRoles, true)) {
    //         unset($this->parentRoles[$key]);
    //         $this->parentRoles = array_values($this->parentRoles);
    //     }

    //     return $this;
    // }

    /**
     * @param array $parentRoles
     *
     * @return ApplicationRole
     */
    // public function setParentRoles(array $parentRoles)
    // {
    //     $this->parentRoles = $parentRoles;

    //     return $this;
    // }

    /**
     * Set currentRole
     *
     * @param \CanalTP\SamCoreBundle\Entity\Role $currentRole
     * @return ApplicationRole
     */
    // public function setCurrentRole(\CanalTP\SamCoreBundle\Entity\Role $currentRole = null)
    // {
    //     $this->currentRole = $currentRole;

    //     return $this;
    // }

    /**
     * Get currentRole
     *
     * @return \CanalTP\SamCoreBundle\Entity\Role
     */
    // public function getCurrentRole()
    // {
    //     return $this->currentRole;
    // }

    // public function __toString()
    // {
    //     return $this->getName();
    // }

    /**
     * Add users
     *
     * @param \CanalTP\SamEcoreUserManagerBundle\Entity\User $user
     * @return ApplicationRole
     */
    public function setUser(\CanalTP\SamEcoreUserManagerBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Remove users
     *
     * @return \CanalTP\SamEcoreUserManagerBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }



    public function getPerimeters()
    {
        return $this->perimeters;
    }

    public function setPerimeters($perimeters)
    {
        $this->perimeters = $perimeters;

        return $this;
    }

    /**
     * Add parents
     * Get parent
     *
     * @param \CanalTP\SamCoreBundle\Entity\UserApplicationRole $parents
     * @return ApplicationRole
     */
    // public function addParent(\CanalTP\SamCoreBundle\Entity\UserApplicationRole $parents)
    // {
    //     $this->parents[] = $parents;

    //     return $this;
    // }

    /**
     * Remove parents
     *
     * @param \CanalTP\SamCoreBundle\Entity\UserApplicationRole $parents
     */
    // public function removeParent(\CanalTP\SamCoreBundle\Entity\UserApplicationRole $parents)
    // {
    //     $this->parents->removeElement($parents);
    // }

    /**
     * Get parents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    // public function getParents()
    // {
    //     return $this->parents;
    // }

    /**
     * @param \Doctrine\Common\Collections\Collection $parents
     * @param ApplicationRole $parent
     *
     * @return ApplicationRole
     */
    // public function setParents(\Doctrine\Common\Collections\Collection $parents)
    // {
    //     $this->parents = $parents;

    //     return $this;
    // }
}
