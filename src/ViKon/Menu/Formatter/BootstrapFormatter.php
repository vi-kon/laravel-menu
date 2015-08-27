<?php

namespace ViKon\Menu\Formatter;

use ViKon\Menu\Component\DropDown;
use ViKon\Menu\Component\Helper\IconableComponent;
use ViKon\Menu\Component\Link;
use ViKon\Menu\Component\Text;

class BootstrapFormatter implements MenuFormatter
{
    /**
     * {@inheritDoc}
     */
    public function formatText(Text $text)
    {
        return '<li>' . $text->getText() . '</li>';
    }

    /**
     * {@inheritDoc}
     */
    public function formatLink(Link $link)
    {
        $content = $link->getText();

        if ($link instanceof IconableComponent) {
            $content = '<i class="' . $link->getIcon() . '"></i> ' . $content;
        }

        if ($link->isActive()) {
            return '<li class="active"><a href="' . $link->getUrl() . '">' . $content . '</a></li>';
        }

        return '<li><a href="' . $link->getUrl() . '">' . $content . '</a></li>';
    }

    /**
     * {@inheritDoc}
     */
    public function formatDropdown(DropDown $dropDown)
    {
        $active  = $dropDown->isActive() ? ' active' : '';
        $content = $dropDown->getText();

        if ($dropDown instanceof IconableComponent) {
            $content = '<i class="' . $dropDown->getIcon() . '"></i> ' . $content;
        }

        $output = '<li class="dropdown' . $active . '">' .
                  '' . '<a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' .
                  '' . '' . $content .
                  '' . '' . '<span class="caret"></span>' .
                  '' . '</a>' .
                  '<ul class="dropdown-menu">';

        foreach ($dropDown->getNestedComponents() as $component) {
            if ($component->isAvailable()) {
                $output .= $component->render();
            }
        }

        return $output . '</ul></li>';
    }
}