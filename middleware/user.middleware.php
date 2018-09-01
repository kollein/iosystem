<?php

namespace middleware\UserMiddleware;

class UserMiddleware
{
    public $_name = 'User MiddleWare';

    public function checkLoginAction()
    {
        $authorized['code'] = 1;
        $authorized['message'] = 'Ok, You have logged!';
        return $authorized;
    }

    public function checkPowerAction()
    {
        $authorized['code'] = 1;
        $authorized['message'] = 'Ok, You have enough power!';
        return $authorized;
    }
}
