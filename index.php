<?php
use app\Configs;
use app\Languages;
use app\App;

require __DIR__ . '/vendor/autoload.php';

// Абсолютный путь проекта
define('ROOT', __DIR__);

// Путь относительно домена
define('SITE', explode($_SERVER['SERVER_NAME'], ROOT)[1] . '/');

// Глобальные настройки
define('CONF', Configs::init()->get());

// Определенный системой язык и массив фраз определенной локали
$lang = new Languages();
define('LANG', $lang->getList());
define('LANG_NAME', $lang->getName());

// Управление кэшем файлов
define('CACHE', CONF['main']['cache'] ? '' : '?' . date('YmdHis'));

App::init();
