<?php

namespace ViKon\Menu\Component\Helper;

/**
 * Interface ActivatableComponent
 *
 * @package ViKon\Menu\Component\Helper
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
interface ActivatableComponent
{
    /**
     * Check if component is active or not
     *
     * @return bool
     */
    public function isActive();
}