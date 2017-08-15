<?php

namespace AppBundle\Menu;


use Knp\Menu\MenuFactory;
use Knp\Menu\MenuItem;

class Builder
{
    /**
     * Main menu generates menu for UI
     *
     * @param MenuFactory $menuFactory
     * @param array       $options
     *
     * @return MenuItem
     */
    public function mainMenu(MenuFactory $menuFactory, array $options): MenuItem
    {
        $menu = $menuFactory->createItem('root');

        $menu->setChildrenAttribute('class', 'navbar-nav mr-auto')
            ->addChild('Home', ['route' => 'homepage'])
            ->setAttribute('class', 'nav-item');

        return $menu;
    }
}