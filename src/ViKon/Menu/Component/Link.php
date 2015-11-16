<?php

namespace ViKon\Menu\Component;

use Illuminate\Support\Str;
use ViKon\Auth\RouterAuth;
use ViKon\Menu\Component\Helper\ActivatableComponent;
use ViKon\Menu\Component\Helper\IconableComponent;
use ViKon\Menu\Component\Helper\IconableComponentTrait;

/**
 * Class Link
 *
 * @package ViKon\Menu\Component
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
class Link extends Text implements ActivatableComponent, IconableComponent
{
    use IconableComponentTrait;

    /** @type string */
    protected $url = '#';

    /** @type string|null */
    protected $route;

    /**
     * Get route URL
     *
     * @return string
     */
    public function getUrl()
    {
        if ($this->url === null) {
            $this->url = $this->route === null
                ? '#'
                : $this->container->make('url')->route($this->route['name'], $this->route['attributes']);
        }

        return $this->url;
    }

    /**
     * Set route URL
     *
     * @param string $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url   = $url;
        $this->route = null;

        return $this;
    }

    /**
     * Set url by route name
     *
     * @param string $name
     * @param array  $attributes
     * @param bool   $authByRoute enable authentication by route roles and permission
     *
     * @return $this
     */
    public function setUrlByRouteName($name, array $attributes = [], $authByRoute = true)
    {
        $this->url   = null;
        $this->route = compact('name', 'attributes');

        if ($authByRoute === true) {
            $this->authenticators[] = function (RouterAuth $routerAuth) use ($name) {
                return $routerAuth->hasAccess($name);
            };
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function isActive()
    {
        // If no URL or Route set, then link cannot be active
        if ($this->url === null && $this->route === null) {
            return false;
        }

        // If URL start with # then it is only client side routing
        if (Str::startsWith($this->url, '#')) {
            return false;
        }

        $pattern = $this->route !== null
            ? ltrim($this->container->make('url')->route($this->route['name'], $this->route['attributes'], false), '/')
            : $this->url;

        /** @noinspection PhpMethodParametersCountMismatchInspection */
        return $this->container->make('request')->is($pattern);
    }

    /**
     * {@inheritDoc}
     */
    protected function format()
    {
        if ($this->formatter === null) {
            return $this->getMenuBuilder()->getMenuFormatter()->formatLink($this);
        }

        return (string)call_user_func($this->formatter, $this);
    }
}