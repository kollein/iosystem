<?php

class Adapter
{

    public function __construct()
    {

    }

    public static function getAddressBefore($mixed)
    {
        return explode('@', $mixed)[0];
    }

    public static function getAddressAfter($mixed)
    {
        return explode('@', $mixed)[1];
    }

}
