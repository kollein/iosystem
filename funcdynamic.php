<?php
class Funcdynamic
{

    // QUICK & SMART : QUERY FOR MYSQL[UPDATE, INSERT] BY INPUT-JSON
    function makeMixQueryMySQL($type)
    {
        $lenNameArr = count($this->_content);
        $strDelimiter = ','; //default in MySQL Injection
        $i = 0;
        foreach ($this->_content as $key => $name) {
            $i++;
            // UPPER KEY
            $keyUPPER = strtoupper($key);
            // DEFINE DELITMITER
            if ($i == $lenNameArr) {
                $strDelimiter = '';
            }
            /* COL_VALUE */
            //important to avoid mysql DIE
            $value = str_replace("'", '"', $this->_content[$key]);
            if ($type == 'insert') {
                $col_value .= "'" . $value . "'" . $strDelimiter;
            } elseif ($type == 'update') {
                // This Special Statement, @$col_value : even have @$col_name
                $col_value .= $keyUPPER . "='" . $value . "'" . $strDelimiter;
            }
            /* COL_NAME */
            $col_name .= $keyUPPER . $strDelimiter;
        }
        //print_r(array($col_name,$col_value));
        return array($col_name, $col_value);
    }

    // CHECK USER WITH HASH: ALWAYS USE IN SYSTEM
    function getUserWithHash()
    {
        $data_return['ID'] = 0;
        // DATA USER FROM COOKIE
        $user_data = json_decode(USER_COOKIE, true);
        $hash = $user_data['hash'];
        // CHECK HASH BEFORE
        if( $hash ){
            // CHECK USERS IN MYSQL
            $query = "SELECT * FROM USERS WHERE hash = '$hash'";
            $this->selectQuery($query);
            $user_finded = $this->_rendata[0];
            if( $user_finded ){
                $data_return = $user_finded;
            }
        }
        return $data_return;        
    }
}
?>