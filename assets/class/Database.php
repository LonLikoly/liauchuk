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

    public function __construct()
    {
        $this->getConnection();
    }

    public function getConnection()
    {
        if (!$this->conn) //проверяет наличие объекта подключения
        {
            try {
                $this->conn = new mysqli ($this->host, $this->username, $this->password, $this->db_name); // если оштбки не обнаружено  
            } 
            catch (Exception $exception) // в случае несоответсвия условиям выводим ошибку 
            {
                echo "Error connection: " . $exception->getMessage();
            }
        }
        return $this->conn;
    }
    public function runQuery($sql)
    {
        try {
            $this->result = $this->conn->query($sql); // выполняем запрос к датабазе (присваивает значению result результат запроса query)
            $this->num_rows = $this->result->num_rows; // присваиваем result значеие num_rows (кол-во строк)
        } 
        catch (Exception $exception)  //иначе выводим ошибку 
        {
            echo "Error connection: " . $exception->getMessage(); //выводит причину ошибки
        }
    }
    public function getRow($sql='') // создаем метод getRow который возвращает строку из результата запроса  в виде ассоц. массива
    {
        if(!$this->result or ($sql and $this->sql != $sql))
        {
            $this->sql = $sql; //присваивем новое значение существующему, если оно отсутствует 
            $this->runQuery($sql); //обращаемся к методу runQuery со значением $sql
        }
        return $this->result->fetch_assoc();  //?mysqli_fetch_assoc — Выбирает следующую строку из набора результатов и помещает её в ассоциативный массив
    }

    public function getArray($sql='') // создаем метод getArray который возвращает неассот.массив ассот.массива и задаем ему значение  $sql=''
    {
        if(!$this->result or ($sql and $this->sql != $sql)) // ?
        {
            $this->sql = $sql; //присваивем новое значение существующему, если оно отсутствует 
            $this->runQuery($sql); //обращаемся к методу runQuery со значением $sql
        }
        if($this->num_rows) // если num_rows!=0 =>
        {
            return $this->result->fetch_all(MYSQLI_ASSOC); //?
        }
        else
        {
            return [];  //?
        }
    }


}