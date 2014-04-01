<?php

namespace CanalTP\SamCoreBundle\Entity;

use FOS\UserBundle\Model\Group as FosGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * Application
 */
class Application extends FosGroup
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
     * @var array
     */
    protected $roles;

    /**
     * @var string
     */
    protected $defaultRoute;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $applicationRoles;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct($name, $roles = array())
    {
        $this->applicationRoles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        parent::__construct($name, $roles);
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
     * @return Application
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
     * @param \CanalTP\SamCoreBundle\Entity\ApplicationRole $applicationRole
     * @return Application
     */
    public function addApplicationRole(\CanalTP\SamCoreBundle\Entity\ApplicationRole $applicationRole)
    {
        $this->addRole($applicationRole->getCanonicalRole());
        $this->applicationRoles[] = $applicationRole;

        return $this;
    }

    /**
     * Remove applicationRole
     *
     * @param \CanalTP\SamCoreBundle\Entity\ApplicationRole $applicationRole
     */
    public function removeApplicationRole(\CanalTP\SamCoreBundle\Entity\ApplicationRole $applicationRole)
    {
        $this->applicationRoles->removeElement($applicationRole);
        $this->removeRole($applicationRole->getCanonicalRole());
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
     * @param array $roles
     *
     * @return Group
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Add users
     *
     * @param \CanalTP\SamEcoreUserManagerBundle\Entity\User $users
     * @return Application
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

    public function getDefaultRoute()
    {
        return $this->defaultRoute;
    }

    public function setDefaultRoute($defaultRoute)
    {
        $this->defaultRoute = $defaultRoute;
    }
}