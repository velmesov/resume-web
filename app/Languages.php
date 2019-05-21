<?php

namespace app;

/**
 * Class Languages
 *
 * @package app
 */
class Languages
{
    /**
     * Определенный системой язык у пользователя
     *
     * @var string $lang_name
     */
    private $lang_name;

    /**
     * Массив фраз
     *
     * @var array $list
     */
    private $list;

    /**
     * Путь к папке локализаций
     *
     * @var string $path
     */
    private $path = ROOT . '/lang/';

    /**
     * Languages constructor
     */
    public function __construct()
    {
        $this->detect();
    }

    /**
     * Определение языка у пользователя
     *
     * @return void
     */
    private function detect()
    {
        if (empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $this->load(CONF['main']['default_lang']);
        } else {
            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            $this->load($lang);
        }
    }

    /**
     * @param string $lang
     *
     * @return void
     */
    private function load(string $lang)
    {
        $path_lang = $this->path . $lang . '.php';

        if (file_exists($path_lang)) {
            $this->lang_name = $lang;
            $this->list = require $path_lang;
        } else {
            $this->lang_name = CONF['main']['default_lang'];
            $this->list = require $this->path . CONF['main']['default_lang'] . '.php';
        }
    }

    /**
     * Возвращает определенный системой язык у пользователя
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->lang_name;
    }

    /**
     * Возвращает массив фраз локализации
     *
     * @return array
     */
    public function getList(): array
    {
        return $this->list;
    }
}
