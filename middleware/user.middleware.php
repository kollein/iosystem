<?php

namespace middleware\user;

class User
{
    public $_name = 'User MiddleWare';

    public function checkLogin()
    {
        $authorized['code'] = 1;
        $authorized['message'] = 'Ok, You has logged!';
        return $authorized;
    }

    public function checkPower()
    {
        $authorized['code'] = 1;
        $authorized['message'] = 'Ok, You have enough power!';
        return $authorized;
    }
}
