<?php

namespace ViKon\Menu\Component\Helper;

/**
 * Interface IconableComponent
 *
 * @package ViKon\Menu\Component\Helper
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
interface IconableComponent
{
    /**
     * Get icon
     *
     * @return string|null
     */
    public function getIcon();

    /**
     * Set icon
     *
     * @param string $icon
     *
     * @return $this
     */
    public function setIcon($icon);
}