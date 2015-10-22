<?php

namespace ViKon\Menu\Component;

use Illuminate\Contracts\Container\Container;
use ViKon\Menu\MenuBuilder;

/**
 * Class AbstractComponent
 *
 * @package ViKon\Menu\Component
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
class AbstractComponent
{
    /** @type  string */
    protected $token;

    /** @type \ViKon\Menu\MenuBuilder */
    protected $menuBuilder;

    /** @type callback|null */
    protected $formatter;

    /** @type callback[] */
    protected $authenticators = [];

    /** @type \Illuminate\Contracts\Container\Container */
    protected $container;

    /**
     * @param string $token unique token to identify component inside menu
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return \ViKon\Menu\MenuBuilder
     */
    public function getMenuBuilder()
    {
        return $this->menuBuilder;
    }

    /**
     * @param \ViKon\Menu\MenuBuilder $menuBuilder
     *
     * @return $this
     */
    public function setMenuBuilder(MenuBuilder $menuBuilder)
    {
        $this->menuBuilder = $menuBuilder;

        return $this;
    }

    /**
     * @return callable|null
     */
    public function getFormatter()
    {
        return $this->formatter;
    }

    /**
     * @param callable $formatter
     *
     * @return $this
     */
    public function setFormatter($formatter)
    {
        $this->formatter = $formatter;

        return $this;
    }

    /**
     * Add new authenticator to set
     *
     * Authenticator processing order depend on add order
     *
     * @param callable|object $authenticator
     *
     * @return $this
     */
    public function addAuthenticator($authenticator)
    {
        $this->authenticators[] = $authenticator;

        return $this;
    }

    /**
     * @return \Illuminate\Contracts\Container\Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param \Illuminate\Contracts\Container\Container $container
     *
     * @return $this
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Check if component is available (user has access)
     *
     * @return bool
     */
    public function isAvailable()
    {
        return $this->authenticate();
    }

    /**
     * Render component
     *
     * @return string
     */
    public function render()
    {
        return $this->format();
    }

    /**
     * Check if component has access or not
     *
     * @return bool
     */
    protected function authenticate()
    {
        // Loop over all added authenticator
        foreach ($this->authenticators as $authenticator) {
            if (is_object($authenticator) && method_exists($authenticator, 'authenticate')) {
                if ($this->container->call([$authenticator, 'authenticate'], ['component' => $this]) !== true) {
                    return false;
                }
            } elseif ($this->container->call($authenticator, [$this]) !== true) {
                return false;
            }
        }

        return true;
    }

    /**
     * Format current component
     *
     * @return string
     */
    protected function format()
    {
        // If no formatter set there is nothing to render
        if ($this->getFormatter() === null) {
            return '';
        }

        return (string)call_user_func($this->formatter, $this);
    }

}