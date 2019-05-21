<?php

namespace app\Controller;

use app\View\ViewError;

/**
 * Class ControllerError
 *
 * @package app\Controller
 */
class ControllerError
{
    /**
     * ControllerError constructor.
     */
    public function __construct()
    {
        $view = new ViewError();
        $view->main();
    }
}
