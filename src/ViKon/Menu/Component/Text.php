<?php

namespace ViKon\Menu\Component;

/**
 * Class Text
 *
 * @package ViKon\Menu\Component
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
class Text extends AbstractComponent
{
    /** @type string */
    protected $text;

    /**
     * @param string $token
     * @param string $text
     */
    public function __construct($token, $text)
    {
        parent::__construct($token);

        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * {@inheritDoc}
     */
    protected function format()
    {
        if ($this->formatter === null) {
            return $this->getMenuBuilder()->getMenuFormatter()->formatText($this);
        }

        return (string)call_user_func($this->formatter, $this);
    }
}