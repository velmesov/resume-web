<?php

namespace app;

use app\Log;

/**
 * Class Template
 *
 * @package app
 */
class Template
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
     * Template constructor
     */
    public function __construct()
    {
        $this->log = Log::init();
    }

    /**
     * @param array $data
     * 
     * @return void
     */
    public function renderPage(array $data)
    {
        foreach ($data as $name => $value) {
            ${$name} = $data[$name];
        }

        $path = ROOT . '/public/pages/' . $page . '/index.php';

        if (file_exists($path)) {
            require $path;
        } else {
            $this->log->view('Не найден файл шаблона: ' . $page, true);
        }
    }

    /**
     * @param array $data
     * 
     * @return string
     */
    public function renderAjax(array $data): string
    {
        foreach ($data as $name => $value) {
            ${$name} = $data[$name];
        }

        $path = ROOT . '/public/pages/ajax/' . $page . '.php';

        if (file_exists($path)) {
            ob_start(null, 0, PHP_OUTPUT_HANDLER_STDFLAGS);
            require $path;
            $template = ob_get_contents();
            ob_end_clean();
        } else {
            $this->log->view('Не найден файл шаблона: ' . $page, true);
        }

        return rawurlencode($template);
    }

    private function __clone()
    { }

    private function __wakeup()
    { }
}
