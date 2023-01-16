<?php

namespace App\PiplModules\roles\Exceptions;

class RoleDeniedException extends AccessDeniedException
{
    /**
     * Create a new role denied exception instance.
     *
     * @param string $role
     */
    public function __construct($role)
    {
        //$this->message = sprintf("You don't have a required ['%s'] role.", $role);
        //dd(sprintf("You don't have a required ['%s'] role.", $role));
        return redirect('/admin/login')->with('login-error',sprintf("You don't have a required ['%s'] role.", $role));
    }
}
