<?php
require_once __DIR__ . '/../core/Database.php';
class BaseModel extends Database {
    protected $connection = null;
    public function __construct() {
        $this->connection = $this->connect();
    }
    private function _query($sql): mysqli_result|bool
    {
        return mysqli_query($this->connection, $sql);
    }

    public function findAll(
        $table,
        $select = ['*'],
        $orderBys = ['name' => 'asc'],
//        $limit = 10
    ): array
    {
        $column = implode(',', $select);
        $orderByString = implode(',', $orderBys);
//        $sql = $orderByString
//            ?   "SELECT $column FROM $table ORDER BY $orderByString LIMIT $limit"
//            :   "SELECT $column FROM $table LIMIT $limit";

        $sql = "SELECT $column FROM $table";

        $query = $this->_query($sql);
        $data = [];
        while ($result = mysqli_fetch_assoc($query)) {
            $data[] = $result;
        }
        return $data;
    }
    public function findById($table, $id): array
    {
        $sql = "SELECT * FROM $table WHERE id = $id";
        $query = $this->_query($sql);
        $data = [];
        while ($result = mysqli_fetch_assoc($query)) {
            $data[] = $result;
        }
        return $data;}

    public function create($table, $data = []): string
    {
        $columns = implode(',', array_keys($data));

        $values = array_map(function ($value) {
            return "'" . $value . "'";
        },array_values($data));

        $newValues = implode(',', $values);

        $sql = "INSERT INTO $table ($columns) VALUES ($newValues)";
        $result = $this->_query($sql);
        if ($result && mysqli_affected_rows($this->connection) > 0) {
            $message = "Câu lệnh INSERT đã thành công!";
        } else {
            $message = "Có lỗi xảy ra hoặc không có dữ liệu được thêm vào.";
        }
        return $message; // chưa ấy ra được message
    }

    public function update($table, $id, $data) {
        $dataSets = [];
        foreach ($data as $key => $value) {
            $dataSets[] = "$key = '" . $value . "'";
        }
        $dataSetString = implode(',', $dataSets);
        $sql = "UPDATE $table SET $dataSetString WHERE id = $id";

        $this->_query($sql);
    }

    public function delete($table, $id) {
        $sql = "DELETE FROM $table WHERE id = $id";
        $this->_query($sql);
    }
}