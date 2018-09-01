<?php

namespace middleware\AdminMiddleware;

class AdminMiddleware
{
    public $_name = 'User MiddleWare';

    public function checkLogin1Action()
    {
        $authorized['code'] = 0;
        $authorized['message'] = 'You dont have permission to access!';
        return $authorized;
    }

    public function checkPower1Action()
    {
        $authorized['code'] = 1;
        $authorized['message'] = 'Ok, You have enough power!';
        return $authorized;
    }
}
