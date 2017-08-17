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
     *
     * @throws \InvalidArgumentException
     */
    public function mainMenu(MenuFactory $menuFactory, array $options): MenuItem
    {
        $menu = $menuFactory->createItem('root')->setChildrenAttribute('class', 'nav navbar-nav');

        $menu->addChild('Home', ['route' => 'homepage'])
             ->setAttribute('class', 'nav-link');

        $menu->addChild('Offer', ['route' => 'offer'])
             ->setAttribute('class', 'nav-link');

        return $menu;
    }
}