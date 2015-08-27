<?php

namespace ViKon\Menu\Component;

use Illuminate\Contracts\Container\Container;
use ViKon\Menu\MenuBuilder;

class AbstractComponent
{
    /** @type  string */
    protected $token;

    /** @type \ViKon\Menu\MenuBuilder */
    protected $menuBuilder;

    /** @type callback|null */
    protected $formatter;

    /** @type callback */
    protected $authenticator;

    /** @type \Illuminate\Contracts\Container\Container */
    protected $container;

    /**
     * @param string $token
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
     * @param callable|object $authenticator
     *
     * @return $this
     */
    public function setAuthenticator($authenticator)
    {
        $this->authenticator = $authenticator;

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
        if ($this->authenticator === null) {
            return true;
        }

        if (is_object($this->authenticator) && method_exists($this->authenticator, 'authenticate')) {
            return (bool)$this->container->call([$this->authenticator, 'authenticate'], ['component' => $this]);
        }

        return (bool)$this->container->call($this->authenticator, [$this]);
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