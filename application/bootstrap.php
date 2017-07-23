<?php
require_once 'core/connection.php';
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';

/*
Здесь обычно подключаются дополнительные модули, реализующие различный функционал:

*/

require_once 'core/route.php';
Route::start(); // запускаем маршрутизатор
