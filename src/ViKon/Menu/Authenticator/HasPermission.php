<?php

namespace ViKon\Menu\Authenticator;
use Illuminate\Contracts\Auth\Guard;


/**
 * Class HasPermission
 *
 * @package ViKon\Menu\Authenticator
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
class HasPermission
{
    /** @type string */
    protected $permission;

    /**
     * @param string $permission
     */
    public function __construct($permission)
    {
        $this->permission = $permission;
    }

    /**
     * @param \Illuminate\Contracts\Auth\Guard $guard
     *
     * @return bool|null
     */
    public function authenticate(Guard $guard)
    {
        return $guard->hasPermission($this->permission);
    }
}