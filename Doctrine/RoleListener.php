<?php

namespace CanalTP\SamCoreBundle\Doctrine;

use CanalTP\SamCoreBundle\Entity\Role;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;

class RoleListener
{
    private $slugify;

    public function __construct($slugify)
    {
        $this->slugify = $slugify;
    }

    private function canonicalize(Role $role)
    {
        $slug = $this->slugify->slugify($role->getName(), '_');

        return 'ROLE_' . strtoupper($slug);
    }

    public function preUpdate(Role $role, PreUpdateEventArgs $event)
    {
        $role->setCanonicalName($this->canonicalize($role));
    }

    public function prePersist(Role $role, LifecycleEventArgs $event)
    {
        $role->setCanonicalName($this->canonicalize($role));
    }
}

