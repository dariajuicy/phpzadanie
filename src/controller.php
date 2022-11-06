<?php

declare(strict_types=1);

namespace App;

include_once('./src/view.php');
require_once('./config/config.php');
require_once('./src/database.php');

class Controller
{
    const DEFAULT_ACTION = 'list';
    private array $getData;
    private array $postData;
    private static array $configuration = [];

    public function __construct(array $getData, array $postData)
    {
        $this->getData = $getData;
        $this->postData = $postData;
        $db = new Database(self::$configuration);
    }

    public static function initConfiguration(array $configuration): void
    {
        self::$configuration = $configuration;
    }

    public function run(): void
    {
        $action = $this->getData['action'] ?? self::DEFAULT_ACTION;
        $view = new View();

        $viewParams = [];

        switch ($action) {
            case 'create':
                $page = 'create';
                $created = false;
                if (!empty($this->postData)) {
                    $viewParams = [
                        'title' => $this->postData['title'],
                        'description' => $this->postData['description'],
                    ];
                    $created = true;
                }
                $viewParams['created'] = $created;
                break;
            default:
                $page = 'list';
                $viewParams['resaultList'] = 'Wyswietlamy liste notatek';
                break;
        }

        $view->render($page, $viewParams);
    }
}
