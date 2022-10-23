<?php

declare(strict_types=1);


namespace App;

// To powinno byc na wersji na swiat. Dla nas bledy sa wazne.
// error_reporting(0);
// ini_set('diaplay_errors', '0');

require_once('./src/view.php');
include_once('.src/utils/debug.php');
const DEFAULT_ACTION = 'list';

$action = $_GET['action']  ?? DEFAULT_ACTION;

$viewParams = [];

if ($action === 'create') {
    $page = 'create';
    $viewParams['resultCreate'] = 'Udalo sie dodac notatke!';
} else {
    $page = 'list';
    $viewParams['resultList'] = 'Wyswietlamy liste notatek';
}

$view = new View();
$view->render($page, $viewParams);
