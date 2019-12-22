<?php
namespace App;

/**
 * Роутер
 */
class Router
{
    private static $routes = array();

    private function __construct(){}

    /**
     * Добавляет маршрут
     * @param $pattern - путь uri
     * @param $callback - метод из контроллера для запуска
     */
    static function addRoute($pattern, $callback, $type_request)
    {
        self::$routes[$pattern] = ['type_request' => $type_request, 'callback' => $callback];
    }

    /**
     * Обработка url и вызов контроллера
     * @param $method
     * @param $url - путь uri
     * @param string $base_path
     * @return mixed
     */
    static public function execute($method, $url, $base_path = '\\App\\Controller\\')
    {
        foreach( self::$routes as $router => $val )
        {
            if( $method === $val['type_request'] && preg_match('#'.$router.'#', $url, $params) )
            {
                $callback = $val['callback'];
                if( !is_array($callback) )
                    $callback = $base_path.$callback;
                array_shift($params);
                return call_user_func_array($callback, $params);
            }
        }
        http_response_code(404);
        return;
    }
}

