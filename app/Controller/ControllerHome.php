<?php

namespace app\Controller;

use app\Session;
use app\View\ViewHome;

/**
 * Class ControllerHome
 *
 * @package app\Controller
 */
class ControllerHome
{
    /**
     * @var Session|object
     */
    private $session;

    /**
     * @var array $parameters
     */
    private $parameters;

    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
        $this->session = Session::init();
    }

    public function main()
    {
        // TODO: Вызов моделей

        $view = new ViewHome();
        $view->main();
    }
}
