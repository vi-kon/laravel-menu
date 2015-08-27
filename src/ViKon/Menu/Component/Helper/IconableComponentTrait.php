<?php

namespace ViKon\Menu\Component\Helper;

/**
 * Class IconableComponentTrait
 *
 * @package ViKon\Menu\Component\Helper
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
trait IconableComponentTrait
{
    protected $icon;

    /**
     * Get icon
     *
     * @return string|null
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set icon
     *
     * @param string $icon
     *
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }
}