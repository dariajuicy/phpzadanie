<?php

declare(strict_types=1);

namespace App;

require_once('./src/view.php')
include_once('./src/utils/debug.php');

$action = $_GET['action'] ?? null;

$view = new View();
$view->render($action);

