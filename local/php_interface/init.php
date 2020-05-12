<?php
// Подключение Composer библиотек.
require __DIR__.'/../vendor/autoload.php';

// Регистрируем библиотеку моделей.
BitrixModel\Service::init();

// Регистрируем отладчик.
BitrixDebugBar\Debug::init();

// Регистрируем логгер.
BitrixMonolog\Log::init();

// Регистрируем автоматическое создание миграций.
BitrixMigrations\Observer::run('migrations', 'local/migrations');

// Подключение сервиса сообщений в админ-панели.
App\Admin\NotifyService::init();

// Дополнение для highload-блока Question.
App\Admin\Question\Service::init();