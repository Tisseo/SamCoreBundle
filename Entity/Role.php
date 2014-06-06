<?php

namespace CanalTP\SamCoreBundle\Entity;

use FOS\UserBundle\Model\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @var string
     */
    private $canonicalName;
    
    /**
     * @var string
     */
    private $isEditable;

    /**
     * @var array
     */
    private $permissions;
    
    /**
     * @var array
     */
    private $businessPermissions;

    /**
     * @var Application
     */
    protected $application;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    //protected $roleParents;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->permissions = array();
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
    
    public function setIsEditable($isEditable)
    {
        $this->isEditable = $isEditable;

        return $this;
    }

    public function getIsEditable()
    {
        return $this->isEditable;
    }

    /**
     * Set canonicalName
     *
     * @param string $canonicalName
     * @return Role
     */
    public function setCanonicalName($canonicalName)
    {
        $this->canonicalName = $canonicalName;

        return $this;
    }

    /**
     * Get canonicalName
     *
     * @return string
     */
    public function getCanonicalName()
    {
        return $this->canonicalName;
    }


    /**
     * Add user
     *
     * @param User $user
     * @return Role
     */
    public function addUser(UserInterface $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param UserInterface $user
     */
    public function removeUser(UserInterface $user)
    {
        $this->users->removeElement($user);
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
     * Add roleParent
     *
     * @param User $roleParent
     * @return Role
     */
    // public function addRoleParent(User $roleParent)
    // {
    //     $this->roleParents[] = $roleParent;

    //     return $this;
    // }

    /**
     * Remove roleParent
     *
     * @param User $roleParent
     */
    // public function removeRoleParent(User $roleParent)
    // {
    //     $this->roleParents->removeElement($roleParent);
    // }

    /**
     * Get roleParents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    // public function getRoleParents()
    // {
    //     return $this->roleParents;
    // }

    /**
     * @param string $application
     *
     * @return Application
     */
    public function setApplication(Application $application)
    {
        $this->application = $application;

        return $this;
    }

    public function getApplication()
    {
        return $this->application;
    }

    /**
     * BusinessPermissions are used to generate menu in sam
     * Must be different of BusinessPermissions
     *
     * @param array $permissions
     * @return string[]
     */
    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;

        return $this;
    }

    public function getPermissions()
    {
        return $this->permissions;
    }
    
    /**
     * BusinessPermissions are used to generate permissions form in sam
     * Must be different of Permissions because BusinessPermissions type change during the process.
     * 
     * @param type $businessPermissions
     * @return CanalTP\SamEcoreApplicationManagerBundle\Security\BusinessPermissionInterface[]
     */
    public function setBusinessPermissions($businessPermissions)
    {
        $this->businessPermissions = $businessPermissions;

        return $this;
    }

    public function getBusinessPermissions()
    {
        return $this->businessPermissions;
    }
}
