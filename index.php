<?php

declare(strict_types=1);


namespace App;

// To powinno byc na wersji na swiat. Dla nas bledy sa wazne.
// error_reporting(0);
// ini_set('diaplay_errors', '0');
require_once('./Exception/AppException.php');
require_once('./Exception/StorageException.php');
require_once('./Exception/ConfigurationExpection.php');
require_once('./src/Controller.php');
include_once('.src/utils/debug.php');
require_once('./config/config.php');

use App\Exception\AppException;
use App\Exception\StorageException;
use App\Exception\ConfigurationException;
use Throwable;

try {
    Controller::initConfiguration($configuration);
    $controller = new Controller($_GET, $_POST);
    $controller->run();
} catch (AppException $e) {
    echo "<h1>Wystąpił błąd w aplikacji</h1>";
    echo '<h3>' . $e->getMessage() . '</h3>';
} catch (Throwable $e) {
    echo "<h1>Wystąpił błąd w aplikacji</h1>";
}

$viewParams = [];

switch ($action) {
    case 'create';
        $created = 'false';
        if (!empty($_POST)) {
            $viewParams = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],

            ];
            $created = true;
        }
        $viewParam['created'] = $created;
        break;
    default:
        $page = 'list';
        $viewParams['resultList'] = 'Wyświetlamy listę notatek';
        break;
}

$view = new View();
$view->render($page, $viewParams);
