<?php

namespace app\Ajax;

/**
 * Class Language
 *
 * @package app\Ajax
 */
class Language
{
    /**
     * @var array $parameters
     */
    private $parameters;

    /**
     * Users constructor.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Возвращает массив локализаций
     *
     * @return void
     */
    public function get()
    {
        echo json_encode([
            'lang' => LANG
        ]);
    }
}
