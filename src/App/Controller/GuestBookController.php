<?php
namespace App\Controller;
use App\Model\GuestBook;
use DateTime;


class GuestBookController
{
    private $db;

    /**
     * GuestBookController constructor.
     * @param $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function actionCreate(){
        $guestBook = new GuestBook($this->db);

        $guestBook->setName($_REQUEST['name']);
        $guestBook->setBody($_REQUEST['body']);
        $guestBook->setDtime(new DateTime());

        if( $guestBook->save() ){
            $this->actionIndex();
        };
    }

    public function actionIndex(){
        $guestBook = new GuestBook($this->db);
        $questBookList = $guestBook->find(5);

        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode($questBookList);
    }
}