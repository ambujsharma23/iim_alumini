<?php

date_default_timezone_set('Asia/Kolkata');
session_start();
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'ambuj');
define('DB_NAME', 'iim_new');

class DB_con {

    private $conn;

    function __construct() {
        $this->conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS) or die('localhost connection problem' . mysqli_error());
        mysqli_select_db($this->conn, DB_NAME);
    }

    public function insert($table, array $values) {
        $column = implode(",", array_keys($values));
        $value = "'" . implode("','", array_values($values)) . "'";
//        echo "INSERT INTO $table ($column) VALUES($value)";
        if (!$this->conn->query("INSERT INTO $table ($column) VALUES($value)")) {
            return mysqli_error($this->conn);
        } else {
            return $this->conn->insert_id;
        }
    }

    public function update($table, array $values, $where) {
        foreach ($values as $key => $value) {
            $val[] = $key . " = " . "'" . $value . "'";
        }
        $update_val = implode(',', $val);

        if (!$this->conn->query("Update $table set $update_val where $where")) {
            return mysqli_error($this->conn);
        } else {
            return 1;
        }
    }

    public function select($table, $col, $where = 1) {
//        echo "SELECT $col FROM $table where $where";
        $res = $this->conn->query("SELECT $col FROM $table where $where");
        $array = array();
        if ($res->num_rows > 0) {
            while ($data = $res->fetch_assoc()) {
                $array[] = $data;
            }
            return $array;
        } else {
            return $array;
        }
    }

    public function select_join($table1, $table2, $col, $join, $condition) {
        $res = $this->conn->query("SELECT $col FROM $table1 $join $table2 on $condition");
        $array = array();
        if ($res->num_rows > 0) {
            while ($data = $res->fetch_assoc()) {
                $array[] = $data;
            }
            return $array;
        } else {
            return $array;
        }
    }

    public function delete($table, $where) {
        $res = $this->conn->query("DELETE FROM $table where $where");
        return $res;
    }

    public function insertcsv($table, array $val) {
        $sql = array();
        foreach ($val as $row) {
            $sql[] = mysqli_real_escape_string($this->myconn, $row);
        }
        $string = "(" . implode('),(', $sql) . ")";
        $query = "INSERT INTO $table   (contact_number) VALUES $string";
        $res = $this->conn->query($query);
        return $res;
    }

    public function custom_query($query) {
        $res = $this->conn->query($query);
        $array = array();
        if ($res->num_rows > 0) {
            while ($data = $res->fetch_assoc()) {
                $array[] = $data;
            }
            return $array;
        } else {
            return $array;
        }
    }

    public function custom_insert($query) {
        $res = $this->conn->query($query);
        return $res;
    }

    public function utf_query() {
        mysqli_set_charset($this->conn, 'utf8');
    }

    public function close_con() {
        mysqli_close($this->conn);
    }

    public function no_return($query) {
        $this->conn->query($query);
        return true;
    }

}
