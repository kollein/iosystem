<?php

namespace controller\user;

class IndexController
{

    public $_name = 'asdsad';

    public function __construct()
    {
        $this->_name = 'vinh';
    }

    public function index()
    {
        return $this->_name;
    }
}