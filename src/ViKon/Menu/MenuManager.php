<?php

namespace ViKon\Menu;

use Illuminate\Contracts\Container\Container;
use ViKon\Menu\Component\AbstractComponent;

/**
 * Class MenuManager
 *
 * @package ViKon\Menu
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
class MenuManager
{
    /** @type \Illuminate\Contracts\Container\Container */
    protected $container;

    /** @type \ViKon\Menu\MenuBuilder[] */
    protected $menus = [];

    /**
     * @param \Illuminate\Contracts\Container\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param string                                  $token     unique identifier for menu
     * @param \ViKon\Menu\Component\AbstractComponent $component component instance
     *
     * @return $this
     */
    public function addComponentToMenu($token, AbstractComponent $component)
    {
        $this->getMenu($token)->addComponent($component);

        return $this;
    }

    /**
     * Get menu by token
     *
     * Note: If menu not exists create new menu builder instance and store under given token.
     *
     * @param string $token unique identifier for menu
     *
     * @return \ViKon\Menu\MenuBuilder
     */
    public function getMenu($token)
    {
        if (!array_key_exists($token, $this->menus)) {
            $this->menus[$token] = new MenuBuilder();
            $this->menus[$token]->setContainer($this->container);
        }

        return $this->menus[$token];
    }

    /**
     * Render given menu
     *
     * @param string $token unique identifier for menu
     *
     * @return string
     */
    public function render($token)
    {
        if (array_key_exists($token, $this->menus)) {

            return $this->menus[$token]->render();
        }

        return '';
    }
}