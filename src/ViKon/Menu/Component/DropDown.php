<?php

namespace ViKon\Menu\Component;

use ViKon\Menu\Component\Helper\ActivatableComponent;
use ViKon\Menu\Component\Helper\IconableComponent;
use ViKon\Menu\Component\Helper\IconableComponentTrait;
use ViKon\Menu\Component\Helper\NestableComponent;
use ViKon\Menu\Component\Helper\NestableComponentTrait;

/**
 * Class DropDown
 *
 * @package ViKon\Menu\Component
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
class DropDown extends Text implements NestableComponent, ActivatableComponent, IconableComponent
{
    use NestableComponentTrait, IconableComponentTrait;

    /**
     * {@inheritDoc}
     */
    public function isActive()
    {
        foreach ($this->nestedComponents as $component) {
            if ($component instanceof ActivatableComponent && $component->isActive()) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    protected function format()
    {
        if ($this->formatter === null) {
            return $this->getMenuBuilder()->getMenuFormatter()->formatDropdown($this);
        }

        return (string)call_user_func($this->formatter, $this);
    }
}