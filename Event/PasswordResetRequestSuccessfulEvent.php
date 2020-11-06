<?php

namespace inem0o\UserPasswordLostBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;

class PasswordResetRequestSuccessfulEvent extends Event
{
    const SUCCESSFUL = 'inem0o.userpasswordlostbundle.successful_reset';

    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }
}