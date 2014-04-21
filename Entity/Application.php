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
     * @var string
     */
    protected $canonicalName;

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
    protected $userRoles;

    protected $role;

    /**
     * Constructor
     */
    public function __construct($name, $roles = array())
    {
        parent::__construct($name, $roles);
        $this->userRoles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add userRole
     *
     * @param \CanalTP\SamCoreBundle\Entity\UserApplicationRole $userRole
     * @return Application
     */
    public function addUserRole(\CanalTP\SamCoreBundle\Entity\UserApplicationRole $userRole)
    {
        //$this->addRole($userRole->getCanonicalRole());
        $this->userRoles[] = $userRole;

        return $this;
    }

    /**
     * Remove userRole
     *
     * @param \CanalTP\SamCoreBundle\Entity\UserApplicationRole $userRole
     */
    public function removeUserRole(\CanalTP\SamCoreBundle\Entity\UserApplicationRole $userRole)
    {
        $this->userRoles->removeElement($userRole);
        //$this->removeRole($userRole->getCanonicalRole());
    }

    /**
     * Get userRoles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserRoles()
    {
        return $this->userRoles;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Appeler avant la mise à jour d'un objet en base de donnée
     */
    public function onPostLoad()
    {
        $aRoles = array();
        foreach ($this->getuserRoles() as $userRole) {
            $aRoles[] = $userRole->getRole()->getCanonicalName();
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

    public function setCanonicalName($canoniName)
    {
        $this->canonicalName = $canoniName;

        return $this;
    }

    public function getCanonicalName()
    {
        return $this->canonicalName;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole(Role $role)
    {
        $this->role = $role;

        return $this;
    }
}
