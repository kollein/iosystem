<?php

namespace controller\user;

class IndexController
{

    public $_name = 'asdsad';

    public function __construct()
    {
        $this->_name = 'vinh';
    }

    public function indexAction()
    {
        return $this->_name;
    }
}
