<?php

namespace controller\user;

use DB;

// use human_model as Model;

class IndexController
{

    public function indexAction()
    {

        DB::connect();
        $query = 'SELECT * FROM user';
        DB::selectQuery($query);

        return DB::$_rendata;
    }
}
