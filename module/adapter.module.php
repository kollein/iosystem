<?php

class Adapter
{

    public function __construct()
    {

    }

    public static function getController($mixed)
    {
        $stack_mixed = explode('@', $mixed);
        return $stack_mixed[0];
    }

    public static function getAction($mixed)
    {
        $stack_mixed = explode('@', $mixed);
        return $stack_mixed[1];
    }

}
