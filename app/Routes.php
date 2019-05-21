<?php

namespace app;

use app\Controller\ControllerError;

/**
 * Class Routes
 *
 * @package app
 */
class Routes
{
    /**
     * @var object $instance
     */
    private static $instance;

    /**
     * @return object
     */
    public static function init()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Routes constructor
     */
    public function __construct()
    {
        $this->parseURL();
    }

    /**
     * Парсинг URL
     *
     * @return void
     */
    private function parseURL()
    {
        // Если пришел Ajax запрос
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $this->ajaxHandler();
        } else {
            // Количество маршрутов
            $count = count(CONF['routes']) - 1;

            foreach (CONF['routes'] as $key => $val) {
                if (preg_match('#^' . CONF['routes'][$key]['pattern'] . '$#', $_SERVER['REQUEST_URI'], $matches)) {
                    $this->generalHandler($key, $matches);
                    break;
                }

                if ($key == $count) {
                    new ControllerError();
                }
            }
        }
    }

    /**
     * Обработка основных запросов
     *
     * @param integer $route_index
     * @param array   $parameters
     * 
     * @return void
     */
    private function generalHandler(int $route_index, array $parameters)
    {
        // Обработка обычных запросов
        if (empty($parameters['api'])) {
            $controller_name = '\app\Controller\Controller' . CONF['routes'][$route_index]['controller'];
            // Обработка API запросов
        } else {
            $controller_name = '\app\Api\\' . CONF['routes'][$route_index]['controller'];
        }

        $this->initController($controller_name, CONF['routes'][$route_index]['method'], $parameters);
    }

    /**
     * Обработка Ajax запросов
     *
     * @return void
     */
    private function ajaxHandler()
    {
        $controller_name = '\app\Ajax\\' . $_POST['handler'];
        $this->initController($controller_name, $_POST['exec'], $_POST);
    }

    /**
     * Инициализация контроллера
     *
     * @param string $controller_name
     * @param string $method_name
     * @param array $parameters
     * 
     * @return void
     */
    private function initController(string $controller_name, string $method_name, array $parameters)
    {
        $controller = new $controller_name($parameters);
        $controller->$method_name();
    }

    private function __clone()
    { }

    private function __wakeup()
    { }
}
