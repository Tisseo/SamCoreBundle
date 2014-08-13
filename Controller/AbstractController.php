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

    protected function isGranted($businessId)
    {
        if ($this->get('security.context')->isGranted($businessId) === false) {
            throw new AccessDeniedException();
        }
    }

    protected function isAllowed($permission)
    {
        if ($this->isGranted($permission) === false) {
            throw new AccessDeniedException($this->get('translator')->trans('forbidden'));
        }
    }

    /**
     * Ajout le message flash dans la session.
     *
     * @param string $type      (alert|error|info|success)
     * @param string $transKey  la clé de traduction
     * @param array  $transOpts $options de substitution
     * @param string $domain    domaine de traduction
     *
     * @return void
     */
    protected function addFlashMessage($type, $transKey, $transOpts = array(), $domain = 'messages')
    {
        $this->get('session')
            ->getFlashBag()
            ->add(
                $type,
                $this->get('translator')->trans($transKey, $transOpts, $domain)
            );
    }
}
