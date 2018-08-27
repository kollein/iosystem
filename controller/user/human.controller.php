<?php

namespace controller\user;

class HumanController
{

    public $_name = 'asdsad';

    public function __construct()
    {
        $this->_name = 'vinh';
    }

    public function index1Action()
    {
        return $this->_name;
    }
}
