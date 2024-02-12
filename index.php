<?php
require __DIR__ . '/app/Http/Database/db.php';
require __DIR__ . '/app/Http/Controllers/Controller.php';
require __DIR__ . '/app/Http/Route/Route.php';

Route::run('/home', 'home@index');
