<?php

namespace app\View;

use app\Template;

/**
 * Class ViewError
 *
 * @package app\View
 */
class ViewError
{
    /**
     * Объект работы со страницами
     *
     * @var object $template
     */
    private $template;

    /**
     * ViewError constructor
     */
    public function __construct()
    {
        $this->template = Template::init();
    }

    public function main()
    {
        $this->template->renderPage([
            'page'        => 'error',
            'title'       => LANG['page_not_found'],
            'author'      => 'Yuri Velmesov',
            'keywords'    => '',
            'description' => '',
            'content'     => LANG['page_not_found']
        ]);
    }
}
