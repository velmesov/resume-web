<?php

namespace app\View;

use app\Template;

/**
 * Class ViewHome
 *
 * @package app\View
 */
class ViewHome
{
    /**
     * Объект работы со страницами
     *
     * @var object $template
     */
    private $template;

    /**
     * ViewHome constructor
     */
    public function __construct()
    {
        $this->template = Template::init();
    }

    public function main()
    {
        $this->template->renderPage([
            'page'        => 'home',
            'title'       => 'Губский Юрий - Резюме',
            'author'      => 'Yuri Velmesov',
            'keywords'    => '',
            'description' => ''
        ]);
    }
}
