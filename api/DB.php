<?php

class DB
{
    protected	$db_name	= 'api';
    protected	$db_prefix	= '';
    protected	$db_user	= 'root';
    protected	$db_pass	= '';
    protected	$db_host	= 'localhost';
    public		$mysqli		= null;

    public function connect()
    {
        $this->mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        $this->mysqli->set_charset('utf8mb4');
        return $this;
    }

    public function processRowSet($rowSet, $singleRow = false)
    {
        $resultArray = array();
        while($row = $rowSet->fetch_assoc())
            array_push($resultArray, $row);
        if(count($resultArray) == 1 && !$singleRow)
            return $resultArray[0];
        return $resultArray;
    }

    public function select($table, $where, $multiple = false, $order = null, $what = "*")
    {
        $sql = "SELECT " . $what . " FROM " . $this->db_prefix. "$table where id > 0 " . (!empty($where) ? " AND $where" : '') .(!empty($oder)  ? " ORDER BY $order": '');

        $result = $this->mysqli->query($sql);

        if(!$result || $result->num_rows == 0) {
            return false;
        }
        return $this->processRowSet($result, $multiple);

    }

    public function insert($table, $data, $log = false) {
        global $_IP;
        $columns = "";
        $values = "";
        foreach ($data as $column => $value) {
            $isb = false;
            if(is_array($value)) {
                $isb	= $value['type'] == 'b';
                $value	= $value['value'];
            }

            $columns .= ($columns == "") ? "" : ", ";
            $columns .= '`' . $column . '`';
            $values	.= ($values == "") ? "" : ", ";
            if($values != 'NULL')
            {
                $value	= stripcslashes($value);
                $value	= $this->mysqli->escape_string($value);
            }
            $values .= $value == 'NULL' ? $value : (($isb ? 'b' : '') . "'" . $value . "'");
        }

        $sql	= "insert into " . $this->db_prefix . "$table ($columns) values ($values)";

        if($this->mysqli->query($sql))
            return $this->mysqli->insert_id;
        else return false;
    }
}

$db = new DB();
$db->connect();
$domain = 'localhost';
$arr = $db->select('users', "`domain` = '$domain'");
/*$domain = 'localhost';
$pass = '4659412AAek@';
$encryptPassword = password_hash($pass, PASSWORD_DEFAULT);
$key = password_hash($domain, PASSWORD_DEFAULT);
$data = [
    'id' => '',
    'domain' => $domain,
    'login' => '$this->login',
    'password' => $encryptPassword,
    'key_user' => $key
];
$db->insert('users', $data);*/


//var_dump($arr);

