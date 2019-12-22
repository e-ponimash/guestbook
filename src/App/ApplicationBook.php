<?php
namespace App;
use App\Controller\GuestBookController;
use App\DB\DB;


class ApplicationBook
{
    /**
     * Базовый класс приложения
     * @package App
     */
    private $requestMethod = null;
    private $config = array();
    private $db;

    /**
     * Application constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
        $this->db = new DB($this->config['DB']);
    }

    public function configRoutes()
    {
        $guestBook = new GuestBookController($this->db);

        Router::addRoute('^/guestBooks$', [$guestBook, 'actionIndex'], 'GET');
        Router::addRoute('^/guestBooks/create$', [$guestBook, 'actionCreate'], 'POST');
    }

    /**
     * Точка входа
     */
    public function run(){
        $uri = preg_replace('/^([^?]+)(\?.*?)?(#.*)?$/', '$1$3', $_SERVER['REQUEST_URI']);

        if( isset($_SERVER['REDIRECT_REQUEST_METHOD']) ) {
            $requestMethod = $_SERVER['REDIRECT_REQUEST_METHOD'];
        }
        if( !isset($this->requestMethod) ){
            $requestMethod = $_SERVER['REQUEST_METHOD'];
        }

        try {
            Router::execute($requestMethod, $uri);
        }catch (\Exception $exc){
            http_response_code(500);
            header('Content-Type: text/plain');
            echo $exc->getMessage();
            echo $exc->getTraceAsString();
        }
    }
}