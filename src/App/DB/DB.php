<?php
namespace App\DB;

use App\Model\Param;
use PDO;

class DB
{
    protected $db;  // PDO Database
    protected $sth; // PDO Statement

    /**
     * Открывает соединение с БД
     * @param array $config
     */
    public function __construct($config=[]){
        $this->db = new PDO($config['dsn']);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $this;
    }

    /**
     * @return $this
     */
    public function bindParams($params){
        foreach ($params as  $key => $value){
            $this->sth->bindValue($key, $value);
        }
        return $this;
    }

    /**
     * Выполняем SQL запрос
     * @param $query
     * @param $params
     * @return mixed
     */
    public function execute($query, $params){
        $this->sth = $this->db->prepare($query);
        if (count($params)){
            $this->bindParams($params);
        }
        $this->sth->execute();
        return $this;
    }

    /**
     * @param $className
     * @return array
     */
    public function fetch(){
        $arr = $this->sth->fetchAll(PDO::FETCH_ASSOC);
        return $arr;
    }
}