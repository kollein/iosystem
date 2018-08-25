<?php

namespace Module\TransferEmail;

class TransferEmailModule
{

    public function isValidEmail($email)
    {
        return strlen($email) > 10 ? true : false;
    }

}
