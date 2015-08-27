<?php

namespace ViKon\Menu\Authenticator;

use ViKon\Menu\Component\AbstractComponent;
use ViKon\Menu\Component\Helper\NestableComponent;

/**
 * Class HasAvailableNestedComponent
 *
 * @package ViKon\Menu\Authenticator
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
class HasAvailableNestedComponent
{
    /**
     * @param \ViKon\Menu\Component\AbstractComponent $component
     *
     * @return bool
     */
    public function authenticate(AbstractComponent $component)
    {
        if ($component instanceof NestableComponent) {
            foreach ($component->getNestedComponents() as $nestedComponent) {
                if ($nestedComponent->isAvailable() === true) {
                    return true;
                }
            }

            return false;
        }

        return true;
    }
}