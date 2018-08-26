<?php

class Adapter
{

    public function __construct()
    {

    }

    public static function getAddressFirst($mixed)
    {
        return explode('@', $mixed)[0];
    }

    public static function getAddressLast($mixed)
    {
        return explode('@', $mixed)[1];
    }

}
