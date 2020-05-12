<?php
// Подключаем ядро Битрикс.
$_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__);

define('BX_NO_ACCELERATOR_RESET', true);
define('NOT_CHECK_PERMISSIONS', true);
define('NO_KEEP_STATISTIC', true);

require $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php';

// Если нужно, подключаем Composer.
require __DIR__.'/vendor/autoload.php';

// Запускаем интерфейс мигратора.
BitrixMigrations\Cli::run('migrations', 'local/migrations');