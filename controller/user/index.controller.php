<?php

namespace controller\user;

use DB;

class IndexController
{

    public function indexAction()
    {
        DB::connect();

        $query = "UPDATE user SET Host = 'matbao3333' WHERE User = 'root'";
        DB::update($query);
        echo json_encode(DB::$_rendata);

        return DB::$_rendata;
    }
}
