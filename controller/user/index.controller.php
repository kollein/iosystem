<?php

namespace controller\user;

use DB;

class IndexController
{

    public function indexAction()
    {
        DB::connect();

        $query = "DELETE FROM user WHERE Host = 'matbao 123'";
        DB::affect($query, true);
        return DB::$_rendata;
    }
}
