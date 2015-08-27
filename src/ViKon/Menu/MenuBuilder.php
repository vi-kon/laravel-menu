<?php

namespace ViKon\Menu;

use Illuminate\Contracts\Container\Container;
use ViKon\Menu\Component\AbstractComponent;
use ViKon\Menu\Formatter\MenuFormatter;

/**
 * Class MenuBuilder
 *
 * @package ViKon\Menu
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
class MenuBuilder
{
    /** @type \ViKon\Menu\Formatter\MenuFormatter */
    protected $menuFormatter;

    /** @type \ViKon\Menu\Component\AbstractComponent[] */
    protected $components = [];

    /** @type \Illuminate\Contracts\Container\Container */
    protected $container;

    /**
     * @param \ViKon\Menu\Component\AbstractComponent $component
     *
     * @return $this
     */
    public function addComponent(AbstractComponent $component)
    {
        $component->setMenuBuilder($this);
        $component->setContainer($this->container);

        $this->components[$component->getToken()] = $component;

        return $this;
    }

    /**
     * Get component
     *
     * @param string $token component unique identifier
     *
     * @return null|\ViKon\Menu\Component\AbstractComponent return NULL if component not found with given token name
     */
    public function getComponent($token)
    {
        if (array_key_exists($token, $this->components)) {
            return $this->components[$token];
        }

        return null;
    }

    /**
     * @return \ViKon\Menu\Formatter\MenuFormatter
     */
    public function getMenuFormatter()
    {
        return $this->menuFormatter;
    }

    /**
     * @param \ViKon\Menu\Formatter\MenuFormatter $menuFormatter
     *
     * @return $this
     */
    public function setMenuFormatter(MenuFormatter $menuFormatter)
    {
        $this->menuFormatter = $menuFormatter;

        return $this;
    }

    /**
     * @return \Illuminate\Contracts\Container\Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param \Illuminate\Contracts\Container\Container $container
     *
     * @return $this
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        $output = '';

        foreach ($this->components as $component) {
            if ($component->isAvailable()) {
                $output .= $component->render();
            }
        }

        return $output;
    }
}