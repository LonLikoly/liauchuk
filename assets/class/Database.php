<?php

class Database
{
    
    private $host = "127.0.0.1";
    private $db_name = "shop";
    private $username = "root";
    private $password = "QAZedcQAZedc";
    public $conn;
    public $result;
    public $info;
    public $insertId;
    public $num_rows;
    public $sql;

    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new mysqli ($this->host, $this->username, $this->password, $this->db_name);
        } catch (PDOException $exception) {
            echo "Error connection: " . $exception->getMessage();
        }

        return $this->conn;
    }
    public function runQuery($sql)
    {
        try {
            $this->result = $this->conn->query($sql);
            $this->info = $this->conn->info;
            $this->insertId =$this->conn->insert_id;
            $this->num_rows = $this->result->num_rows;
        } catch (PDOException $exception) {
            echo "Error connection: " . $exception->getMessage();
        }


    }
    public function getRow($sql='')
    {
        if(!$this->result or ($sql and $this->sql != $sql))
        {
            $this->sql = $sql;
            $this->runQuery($sql);
        }
        return $this->result->fetch_assoc();
    }

    public function getArray($sql='')
    {
        if(!$this->result or ($sql and $this->sql != $sql))
        {
            $this->sql = $sql;
            $this->runQuery($sql);
        }
        if($this->num_rows > 0)
        {
            return $this->result->fetch_all(MYSQLI_ASSOC);
        }
        else
        {
            return [];
        }
    }


}