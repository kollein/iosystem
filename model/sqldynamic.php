<?php
class Model_sqlDynamic extends Funcdynamic
{
    protected $_conn;
    public $_rendata;
    public $_content;
    public $_extra;
    public function __construct($conn, $arg1 = null, $arg2 = null)
    {
        $this->_conn = $conn;
        $this->_content = $arg1;
    }
    public function insertRow($tb_name, $col_name, $col_value, $returndata)
    {
        $query = "INSERT INTO " . $tb_name . "(" . $col_name . " )VALUES(" . $col_value .
            " )";
        $this->_conn->exec($query) or die('DIE');
        $lastId = $this->_conn->lastInsertId();
        if ($returndata == true) {
            $this->_rendata = $lastId . "," . $col_value;
        } else {
            $this->_rendata = $lastId;
        }
    }
    public function insertQuery($query, $returndata = false)
    {
        $this->_conn->exec($query) or die('DIE');
        $lastId = $this->_conn->lastInsertId();
        if ($returndata == true) {
            $this->_rendata = $lastId . "," . $col_value;
        } else {
            $this->_rendata = $lastId;
        }
    }
    public function updateRow($tb_name, $name_value, $where, $returndata)
    {
        $stmt = $this->_conn->query("UPDATE " . $tb_name . " SET " . $name_value . " $where ");
        $rowCount = $stmt->rowCount();
        if ($returndata == true) {
            //waiting
        } else {
            $this->_rendata = $rowCount;
        }
    }
    public function updateQuery($query)
    {
        $stmt = $this->_conn->query($query) or die('DIE');
        $rowCount = $stmt->rowCount();
        $this->_rendata = $rowCount;
    }
    public function deleteRow($tb_name, $where, $isMapID)
    {
       if($isMapID){
          foreach($this->_content as $item){
              $whereNow = $where.$item['id'];
              $this->_conn->exec("DELETE FROM " . $tb_name . " $whereNow ");
          }
       }

    }
    public function selectRow($tb_name, $where)
    {
        $this->_rendata = array(); //data return an array !important
        $stmt = $this->_conn->query("SELECT *FROM $tb_name $where") or die(__FUNCTION__.'->DIE');
        $this->_rendata = $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    public function selectQuery($query)
    {
        $this->_rendata = array(); //data return an array !important
        $stmt = $this->_conn->query($query) or die(__FUNCTION__.'->DIE');
        $this->_rendata = $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    public function countRow($tb_name, $where)
    {
        $this->_rendata = array(); //data return an array !important
        $stmt = $this->_conn->query("SELECT COUNT(*) FROM " . $tb_name . " $where") or die(__FUNCTION__."::{$tb_name}->DIE");
        $this->_rendata = $stmt->fetch(PDO::FETCH_NUM);
    }
}
?>