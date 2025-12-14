<?php
require_once 'BaseModel.php';
class UserModel extends BaseModel {
    const TABLE_NAME = "customers";

    protected $connection = null;

    public function __construct() {
        $this->connection = $this->connect();
    }

    private function _query($sql){
        return mysqli_query($this->connection, $sql);
    }

    public function checkPhoneExists($phone) {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE phone = '" . mysqli_real_escape_string($this->connection, $phone) . "'";
        $result = $this->_query($sql);
        return mysqli_num_rows($result) > 0;
    }

}