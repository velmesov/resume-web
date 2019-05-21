<?php

namespace app;

/**
 * Class App
 *
 * @package app
 */
class Response
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
     * App constructor
     */
    public function __construct()
    { }

    /**
     * Возвращает JSON данные
     *
     * @param array $data
     * 
     * @return string JSON данные
     */
    public function json(array $data)
    {
        return json_encode($data);
    }

    private function __clone()
    { }

    private function __wakeup()
    { }
}
