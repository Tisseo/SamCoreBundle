<?php

namespace CanalTP\SamCoreBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use CanalTP\SamEcoreApplicationManagerBundle\Menu\BusinessMenuItemInterface;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory)
    {
        $translator = $this->container->get('translator');
        $menu = $factory->createItem('root');
        $menu->setChildrenAttributes(array('class' => 'navbar-nav'));
        $menu->addChild(
            $translator->trans('ctp_user.user._menu'),
            array('route' => 'sam_user_list')
        );
        $menu->addChild(
            "Role",
            array('route' => 'sam_role')
        );

        $menu->addChild(
            "Permission",
            array('route' => 'sam_security_business_right_edit')
        );

        return $menu;
    }

    public function businessMenu(FactoryInterface $factory)
    {
        $businessComponent = $this->container->get('sam.business_component');
        $app = $this->container->get('canal_tp_sam.application.finder')->getCurrentApp();
        $menu = $factory->createItem('root');

        if ($app) {
            $businessMenu = $businessComponent->getBusinessComponent($app->getCanonicalName())->getMenuItems();

            $menu->setChildrenAttributes(array('class' => 'navbar-nav nav'));
            foreach ($businessMenu as $menuItem) {
                $this->generateKnpMenu($menuItem, $menu);
            }
        } else {
            $menu->setChildrenAttributes(array('class' => 'navbar-nav nav'));
        }

        /** @var \Knp\Menu\MenuItem $children */
        /** TODO update the code below if there is a multilevel dropdown menu. */
        foreach($menu->getChildren() as $children) {
            if ($children->hasChildren()) {
                $children->setAttribute('class', 'dropdown');
                $children->setLinkAttributes([
                    'class' => 'dropdown-toggle',
                    'data-toggle' => 'dropdown',
                ]);
                $children->setLabel($children->getLabel() . ' <span class="caret"></span>');
                $children->setChildrenAttribute('class', "dropdown-menu");
            }
        }
        return $menu;
    }

    protected function generateKnpMenu(BusinessMenuItemInterface $menuItem, $knpMenu, $parentName = null)
    {
        $options = ['extras' => ['safe_label' => true]];
        if (!is_null($menuItem->getRoute()) && $menuItem->getRoute() != '') {
            $options += array('route' => $menuItem->getRoute());
        }
        $options += array('routeParameters' => $menuItem->getParameters());
        $attributes = $menuItem->getAttributes();
        if ($menuItem->isActive($this->container->get('request_stack')->getCurrentRequest()->get('_route'))) {
            $attributes += array('class' => 'active');
        }
        $options += array('attributes' => $attributes);
        if (!is_null($parentName)) {
            $knpMenu[$parentName]->addChild(
                $menuItem->getName(),
                $options
            );
        } else {
            $knpMenu->addChild(
                $menuItem->getName(),
                $options
            );
        }
        foreach ($menuItem->getChildren() as $child) {
            $this->generateKnpMenu($child, $knpMenu, $menuItem->getName());
        }
    }
}
