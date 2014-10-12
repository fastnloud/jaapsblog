<?php

namespace Auth\Validator\Callback;

use User\Entity\User;

class Bcrypt
{

    /**
     * Callback function used when verifying the User credentials.
     *
     * @param User $user
     * @param $passwordGiven
     * @return bool
     */
    public function validate(User $user, $passwordGiven)
    {
        $password = $user->getPassword();

        $bcrypt = new \Zend\Crypt\Password\Bcrypt();
        if ($bcrypt->verify($passwordGiven, $password)) {
            return true;
        } else {
            return false;
        }
    }

}