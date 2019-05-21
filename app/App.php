<?php

namespace app;

use app\Log;
use app\Routes;

/**
 * Class App
 *
 * @package app
 */
class App
{
    /**
     * @var object $instance
     */
    private static $instance;

    /**
     * Объект логирования
     *
     * @var object $log
     */
    private $log;

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
     * App constructor
     */
    public function __construct()
    {
        $this->log = Log::init();
        $this->start();
    }

    /**
     * Запуск приложения
     *
     * @return void
     */
    private function start()
    {
        // Если версия PHP не удовлетворяет мин. требованиям
        if (version_compare(PHP_VERSION, CONF['main']['min_php_version'], '<')) {
            $this->log->view(sprintf(L['core_min_php_version'], PHP_VERSION, CONF['main']['min_php_version']), true);
        }

        // Подключаем роутер
        Routes::init();
    }

    private function __clone()
    { }

    private function __wakeup()
    { }
}
