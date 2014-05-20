<?php

namespace CanalTP\SamCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

abstract class AbstractController extends Controller
{
    protected function checkPermission($object, $permission)
    {
        if (false === $this->get('security.context')->isGranted($permission, $object)) {
            throw new AccessDeniedException();
        }
    }
    
    protected function isGranted($permission)
    {
        return $this->get('security.context')->isGranted($permission);
    }
    
    protected function isAllowed($permission)
    {
        if ($this->isGranted($permission) === false) {
            throw new AccessDeniedException($this->get('translator')->trans('forbidden'));
        }
    }
}
