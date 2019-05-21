<?php

namespace app;

/**
 * Class Session
 *
 * @package app
 */
class Session
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
     * Session constructor
     */
    public function __construct()
    {
        $this->log = Log::init();
        $this->start();
    }

    /**
     * Запуск сессии
     *
     * @return void
     */
    private function start()
    {
        if (session_status() == PHP_SESSION_DISABLED) {
            $this->log->view(L['session_disabled'], true);
        } elseif (session_status() == PHP_SESSION_NONE) {
            $session_conf = [
                'name'            => CONF['session']['name'],
                'use_strict_mode' => CONF['session']['strict_mode'],
                'gc_maxlifetime'  => CONF['session']['maxlifetime'],
                'cookie_lifetime' => CONF['session']['maxlifetime'],
                'cookie_path'     => CONF['session']['cookie_path'],
                'cookie_httponly' => CONF['session']['cookie_httponly'],
                'save_path'       => ROOT . CONF['session']['save_path'],
            ];

            if (session_start($session_conf) == false) {
                $this->log->view(L['session_start_error'], true);
            }
        }
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return void
     */
    public function set(string $name, $value)
    {
        $_SESSION[CONF['session']['name']][$name] = $value;
    }

    /**
     * @param string $name
     *
     * @return array|false
     */
    public function get(string $name)
    {
        if (isset($_SESSION[CONF['session']['name']][$name])) {
            $result = $_SESSION[CONF['session']['name']][$name];
        } else {
            $result = false;
        }

        return $result;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function remove(string $name): bool
    {
        if (isset($_SESSION[CONF['session']['name']][$name])) {
            $_SESSION[CONF['session']['name']][$name] = null;
            unset($_SESSION[CONF['session']['name']][$name]);

            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    /**
     * Удаляет все сессии
     * @return bool
     */
    public function destroy()
    {
        return session_destroy();
    }

    private function __clone()
    { }

    private function __wakeup()
    { }
}
