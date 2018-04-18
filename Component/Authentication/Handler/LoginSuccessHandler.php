<?php

namespace CanalTP\SamCoreBundle\Component\Authentication\Handler;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Session\Session;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface {

    protected $doctrine;
    protected $router;
    protected $session;

    public function __construct(Doctrine $doctrine, Router $router, Session $session)
    {
        $this->doctrine = $doctrine;
        $this->router = $router;
        $this->session = $session;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $user = $token->getUser();
        $userRoles = $user->getUserRoles();

        $targetPath = $request->request->get('_target_path');
        if (!empty($targetPath)) {
            return new RedirectResponse($targetPath);
        }

        foreach ($userRoles as $role) {
            $defaultRoute = $role->getApplication()->getDefaultRoute();
            if (!is_null($defaultRoute)) {
                if ($this->router->getMatcher()->getContext()->getMethod() === 'POST') {
                    // Force GET (if POST, default route is not found)
                    $this->router->getMatcher()
                        ->getContext()
                        ->setMethod('GET');
                }
                $defaultRoute = $this->router->match($defaultRoute);

                return new RedirectResponse($this->router->generate($defaultRoute['_route']));
            }
        }

        return new RedirectResponse($this->router->generate('canal_tp_sam_homepage'));
    }

}
