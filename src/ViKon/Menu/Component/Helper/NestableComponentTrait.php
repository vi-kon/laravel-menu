<?php

namespace ViKon\Menu\Component\Helper;

use Illuminate\Contracts\Container\Container;
use ViKon\Menu\Component\AbstractComponent;
use ViKon\Menu\MenuBuilder;

/**
 * Class NestableComponentTrait
 *
 * @package ViKon\Menu\Component\Helper
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
trait NestableComponentTrait
{
    /** @type \ViKon\Menu\Component\AbstractComponent[] */
    protected $nestedComponents = [];

    /**
     * @param \ViKon\Menu\Component\AbstractComponent $nestedComponent
     *
     * @return $this
     */
    public function addNestedComponent(AbstractComponent $nestedComponent)
    {
        $this->nestedComponents[$nestedComponent->getToken()] = $nestedComponent;

        /** @type \ViKon\Menu\Component\AbstractComponent $this */
        if ($this->getMenuBuilder() !== null) {
            $nestedComponent->setMenuBuilder($this->getMenuBuilder());
        }

        if ($this->getContainer() !== null) {
            $nestedComponent->setContainer($this->getContainer());
        }

        return $this;
    }

    /**
     * @return \ViKon\Menu\Component\AbstractComponent[]
     */
    public function getNestedComponents()
    {
        return $this->nestedComponents;
    }

    /**
     * @param \Illuminate\Contracts\Container\Container $container
     *
     * @return $this
     */
    public function setContainer(Container $container)
    {
        /** @type \ViKon\Menu\Component\AbstractComponent|\ViKon\Menu\Component\Helper\NestableComponentTrait $this */

        /** @noinspection PhpUndefinedMethodInspection */
        parent::setContainer($container);

        foreach ($this->nestedComponents as $nestedComponent) {
            $nestedComponent->setContainer($container);
        }

        return $this;
    }

    /**
     * @param \ViKon\Menu\MenuBuilder $menuBuilder
     *
     * @return $this
     */
    public function setMenuBuilder(MenuBuilder $menuBuilder)
    {
        /** @type \ViKon\Menu\Component\AbstractComponent|\ViKon\Menu\Component\Helper\NestableComponentTrait $this */

        /** @noinspection PhpUndefinedMethodInspection */
        parent::setMenuBuilder($menuBuilder);

        foreach ($this->nestedComponents as $nestedComponent) {
            $nestedComponent->setMenuBuilder($menuBuilder);
        }

        return $this;
    }

}