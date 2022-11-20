<?php
namespace App;
//w wersji na świat, dla nas błędy są ważne
//error_reporting(0);
//ini_set('display_errors', '0');
require_once('./Exception/AppException.php');
require_once('./Exception/StorageException.php');
require_once('./Exception/ConfigurationException.php');
require_once('./src/controller.php');
require_once('./src/request.php');
include_once('./src/utils/debug.php');
require_once('./config/config.php');

use App\Exception\AppException;
use App\Exception\StorageException;
use App\Exception\ConfigurationException;
use App\Request;
use Throwable;

$request = [
    'get' => $_GET,
    'post' => $_POST,
];
$request = new Request($_GET, $_POST);

try {
    Controller::initConfiguration($configuration);
@@ -32,4 +31,5 @@
    echo '<h3>' . $e->getMessage() . '</h1>';
} catch (Throwable $e) {
    echo "<h1>Wystąpił błąd w aplikacji</h1>";
    dump($e);
}
  24  
src/controller.php
@@ -5,6 +5,7 @@
namespace App;

use App\Exception\NotFoundException;
use App\Request;

include_once('./src/view.php');
require_once('./config/config.php');
@@ -16,9 +17,9 @@ class Controller
    private static array $configuration = [];
    private Database $database;
    private View $view;
    private array $request;
    private Request $request;

    public function __construct(array $request)
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->view = new View();
@@ -37,11 +38,10 @@ public function run(): void
            case 'create':
                $page = 'create';

                $data = $this->getRequestPost();
                if (!empty($data)) {
                if ($this->request->hasPost()) {
                    $noteData = [
                        'title' => $data['title'],
                        'description' => $data['description'],
                        'title' => $this->request->postParam['title'],
                        'description' => $this->request->postParam['description'],
                    ];

                    $this->database->createNote($noteData);
@@ -52,8 +52,8 @@ public function run(): void

            case 'show':
                $page = 'show';
                $data = $this->getRequestGet();
                $noteId = (int) $data['id'] ?? null;
                $noteId = (int) $this->request->getParam('id');

                if (!$noteId) {
                    header('Location: /?error=missingNoteId');
                    exit;
@@ -72,11 +72,10 @@ public function run(): void
                break;
            default:
                $page = 'list';
                $data = $this->getRequestGet();
                $viewParams = [
                    'notes' => $this->database->getNotes(),
                    'before' => $data['before'] ?? null,
                    'error' => $data['error'] ?? null,
                    'before' => $this->request->getParam('before'),
                    'error' => $this->request->getParam('error'),
                ];
                break;
        }
@@ -85,8 +84,7 @@ public function run(): void

    private function action(): string
    {
        $data = $this->getRequestGet();
        return $data['action'] ?? self::DEFAULT_ACTION;
        return $this->request->getParam('action', self::DEFAULT_ACTION);
    }

    private function getRequestPost(): array