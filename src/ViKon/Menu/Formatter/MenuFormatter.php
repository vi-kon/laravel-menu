<?php

namespace ViKon\Menu\Formatter;

use ViKon\Menu\Component\DropDown;
use ViKon\Menu\Component\Link;
use ViKon\Menu\Component\Text;

interface MenuFormatter
{
    /**
     * @param \ViKon\Menu\Component\Text $text
     *
     * @return string
     */
    public function formatText(Text $text);

    /**
     * @param \ViKon\Menu\Component\Link $link
     *
     * @return string
     */
    public function formatLink(Link $link);

    /**
     * @param \ViKon\Menu\Component\DropDown $dropDown
     *
     * @return string
     */
    public function formatDropdown(DropDown $dropDown);

}