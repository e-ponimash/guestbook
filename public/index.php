<?php
require_once __DIR__ . '/../src/autoload.php';
require_once '../config/app.php';

use \App\ApplicationBook;

$app = new ApplicationBook(app);
$app->configRoutes();
$app->run();