<?php

declare(strict_types=1);

namespace App;

include_once('./src/View.php');

class Controller
{
    const DEFAULT_ACTION = 'list';
    private array $getData;
    private array $postData;

    public function __construct(array $getData, array $postData)
    {
        $this->getData = $getData;
        $this->postData = $postData;
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
