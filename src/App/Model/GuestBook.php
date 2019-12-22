<?php
namespace App\Model;
use App\DB\DB;

class GuestBook
{
    private $db;
    private $id;
    private $dtime;
    private $name;
    private $body;
    /**
     * guestBook constructor.
     * @param DB $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDtime()
    {
        return $this->dtime;
    }

    /**
     * @param mixed $dtime
     */
    public function setDtime($dtime)
    {
        $this->dtime = $dtime;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Сохраняет модель в БД
     * @return mixed
     */
    public function save(){
        $this->db->execute(
            "insert into guest_book(dtime, name, body) values (:dtime, :name, :body)",
            [
                ':dtime' => $this->getDtime()->format('Y-m-d H:i:s'),
                ':name' => $this->getName(),
                ':body' => $this->getBody()
            ]
        );
        return true;
    }

    /**
     * Поиск модели в БД
     * @param int $limit
     * @return array
     */
    public function find($limit=5){
        $this->db->execute(
            "SELECT * FROM guest_book ORDER BY dtime DESC LIMIT :limit",
            [
                ':limit' => $limit
            ]
        );
        return $this->db->fetch();
    }
}