<?php

namespace app;

/**
 * Class Configs
 *
 * @package app
 */
class Configs
{
    /**
     * @var string $path
     */
    private $path = ROOT . '/conf/';

    /**
     * @var array $conf
     */
    private $conf = [];

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
     * Configs constructor
     */
    public function __construct()
    {
        $this->find();
    }

    /**
     * Поиск конфигурационных файлов
     *
     * @return void
     */
    private function find()
    {
        foreach (glob($this->path . '*.php', GLOB_ERR | GLOB_NOSORT) as $file) {
            $configs = require $file;
            $this->addConfig($configs, $file);
        }
    }

    /**
     * @param array  $configs
     * @param string $file
     *
     * @return void
     */
    private function addConfig(array $configs, string $file)
    {
        foreach ($configs as $index => $params) {
            if (array_key_exists($index, $this->conf)) {
                // TODO: Оформить через шаблон
                echo '<span style="color: red;">Ошибка:</span> Конфигурационный файл "<b>' . basename($file) . '</b>" не подключен<br>' . PHP_EOL;
                echo 'Секция настроек с названием "<b>' . $index . '</b>" уже существует';
                exit();
            } else {
                $this->conf[$index] = $params;
            }
        }
    }

    /**
     * Возвращает массив настроек
     *
     * @return array
     */
    public function get(): array
    {
        return $this->conf;
    }

    private function __clone()
    { }

    private function __wakeup()
    { }
}
