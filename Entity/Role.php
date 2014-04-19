<?php

namespace CanalTP\SamCoreBundle\Entity;

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
     * @var array
     */
    private $permissions;

    /**
     * @var Application
     */
    protected $application;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $roleParents;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $userApplications;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userApplications = new ArrayCollection();
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
        $this->setCanonicalName($this->canonicalize($name));

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
     * Add applicationRole
     *
     * @param \CanalTP\SamCoreBundle\Entity\UserApplicationRole $applicationRole
     * @return Role
     */
    public function addUserApplication(\CanalTP\SamCoreBundle\Entity\UserApplicationRole $applicationRole)
    {
        $this->userApplications[] = $applicationRole;

        return $this;
    }

    /**
     * Remove applicationRole
     *
     * @param \CanalTP\SamCoreBundle\Entity\UserApplicationRole $applicationRole
     */
    public function removeUserApplication(\CanalTP\SamCoreBundle\Entity\UserApplicationRole $applicationRole)
    {
        $this->userApplications->removeElement($applicationRole);
    }

    /**
     * Get userApplications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserApplications()
    {
        return $this->userApplications;
    }

    /**
     * Add roleParent
     *
     * @param \CanalTP\SamCoreBundle\Entity\UserApplicationRole $roleParent
     * @return Role
     */
    public function addRoleParent(\CanalTP\SamCoreBundle\Entity\UserApplicationRole $roleParent)
    {
        $this->roleParents[] = $roleParent;

        return $this;
    }

    /**
     * Remove roleParent
     *
     * @param \CanalTP\SamCoreBundle\Entity\UserApplicationRole $roleParent
     */
    public function removeRoleParent(\CanalTP\SamCoreBundle\Entity\UserApplicationRole $roleParent)
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

    // @todo better in an event
    private function canonicalize($role)
    {
        return strtoupper('ROLE_' . $this->slugify($role, '_'));
    }

    public function slugify($text, $separator = '-')
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', $separator, $text);

        // trim
        $text = trim($text, $separator);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
