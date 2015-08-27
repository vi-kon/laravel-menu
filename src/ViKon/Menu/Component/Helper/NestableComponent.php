<?php

namespace ViKon\Menu\Component\Helper;

use ViKon\Menu\Component\AbstractComponent;

/**
 * Interface NestableComponent
 *
 * @package ViKon\Menu\Component\Helper
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
interface NestableComponent
{
    /**
     * @param \ViKon\Menu\Component\AbstractComponent $component
     *
     * @return $this
     */
    public function addNestedComponent(AbstractComponent $component);

    /**
     * @return \ViKon\Menu\Component\AbstractComponent[]
     */
    public function getNestedComponents();
}