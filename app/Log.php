<?php

namespace app;

/**
 * Class Log
 *
 * @package app
 */
class Log
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
     * Log constructor
     */
    private function __construct()
    {
        $this->setErrorHandlers();
    }

    /**
     * Установка собственных обработчиков ошибок и исключений
     *
     * @return void
     */
    private function setErrorHandlers()
    {
        set_error_handler([$this, 'errorHandler']);
        set_exception_handler([$this, 'exceptionHandler']);
    }

    /**
     * Обработчик ошибок
     * 
     * @param int    $errno
     * @param string $errstr
     * @param string $errfile
     * @param int    $errline
     *
     * @return void
     */
    public function errorHandler(int $errno, string $errstr, string $errfile, int $errline)
    {
        $this->createText($errno, $errstr, $errfile, $errline);
    }

    /**
     * Обработчик исключений
     * 
     * @param \Throwable $e
     *
     * @return void
     */
    public function exceptionHandler(\Throwable $e)
    {
        $this->createText($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
    }

    /**
     * @param int    $errno
     * @param string $errstr
     * @param string $errfile
     * @param int    $errline
     *
     * @return void
     */
    private function createText(int $errno, string $errstr, string $errfile, int $errline)
    {
        $timestamp = $this->timestamp();

        $text_log = <<<LOG
$timestamp
Ошибка #$errno,
Описание $errstr,
Файл $errfile,
Строка №$errline\n\n
LOG;
        $this->writeLog($text_log);

        // Если включен режим разработки
        if (CONF['main']['debug']) {
            $text = <<<HTML
Ошибка #$errno<br>
Описание: $errstr<br>
Файл: $errfile<br>
Строка №$errline
HTML;
            $this->view($text, true);
        }
    }

    /**
     * Показ сообщения в браузере
     *
     * @param string $text  Сообщение
     * @param bool   $break Прерывание скрипта
     *
     * @return void
     */
    public function view(string $text, bool $break = false)
    {
        echo $text;

        if ($break) {
            exit();
        }
    }

    /**
     * Запись логов в файл
     *
     * @param string $text
     * @param bool   $break
     *
     * @return void
     */
    private function writeLog(string $text, bool $break = false)
    {
        // TODO: переписать на запись в базу
        file_put_contents(ROOT . CONF['main']['path_log'] . '/error.log', $text, FILE_APPEND);

        if ($break) {
            exit();
        }
    }

    /**
     * Текущая дата и время
     *
     * @return string
     */
    private function timestamp(): string
    {
        return date('Y-m-d H:i:s');
    }

    private function __clone()
    { }

    private function __wakeup()
    { }
}
