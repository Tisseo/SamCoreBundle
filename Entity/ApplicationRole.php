<?php

namespace CanalTP\SamCoreBundle\Entity;

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
     * @var array
     */
    private $permissions;

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
    private $parent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $users;

    protected $currentRole;
    protected $parentRoles;

    private $perimeters;

    /**
     * Constructor
     */
    public function __construct($parentRoles = array())
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->permissions = array();
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
     * Add children
     *
     * @param \CanalTP\SamCoreBundle\Entity\ApplicationRole $children
     * @return ApplicationRole
     */
    // public function addChildren(\CanalTP\SamCoreBundle\Entity\ApplicationRole $children)
    // {
    //     $this->children[] = $children;

    //     return $this;
    // }

    /**
     * Remove children
     *
     * @param \CanalTP\SamCoreBundle\Entity\ApplicationRole $children
     */
    // public function removeChildren(\CanalTP\SamCoreBundle\Entity\ApplicationRole $children)
    // {
    //     $this->children->removeElement($children);
    // }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    // public function getChildren()
    // {
    //     return $this->children;
    // }

    /**
     * Get parent
     *
     * @return ApplicationRole
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param ApplicationRole $parent
     *
     * @return ApplicationRole
     */
    public function setParent(ApplicationRole $parent)
    {
        $this->parent = $parent;

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
     * @param \CanalTP\SamCoreBundle\Entity\Role $currentRole
     * @return ApplicationRole
     */
    public function setCurrentRole(\CanalTP\SamCoreBundle\Entity\Role $currentRole = null)
    {
        $this->currentRole = $currentRole;

        return $this;
    }

    /**
     * Get currentRole
     *
     * @return \CanalTP\SamCoreBundle\Entity\Role
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
     * @param \CanalTP\SamEcoreUserManagerBundle\Entity\User $users
     * @return ApplicationRole
     */
    public function addUser(\CanalTP\SamEcoreUserManagerBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \CanalTP\SamEcoreUserManagerBundle\Entity\User $users
     */
    public function removeUser(\CanalTP\SamEcoreUserManagerBundle\Entity\User $users)
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

    /**
     * Set permissions
     *
     * @param array $permissions
     * @return ApplicationRole
     */
    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;

        return $this;
    }

    /**
     * Get permissions
     *
     * @return array
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * Get permissions
     *
     * @return array
     */
    public function loadPermissions($nbPermissions = 0)
    {
        $i = $nbPermissions - count($this->permissions);

        while ($i-- > 0) {
            $this->permissions[] = '';
        }
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
}
