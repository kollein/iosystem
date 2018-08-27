<?php

namespace middleware\usermiddleware;

class UserMiddleware
{
    public $_name = 'User MiddleWare';

    public function checkLoginAction()
    {
        $authorized['code'] = 1;
        $authorized['message'] = 'Ok, You has logged!';
        return $authorized;
    }

    public function checkPowerAction()
    {
        $authorized['code'] = 1;
        $authorized['message'] = 'Ok, You have enough power!';
        return $authorized;
    }
}
