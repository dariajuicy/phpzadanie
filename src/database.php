<?php

declare(strict_types=1);

namespace App;

use PDO;

class Database
{
    public function __construct(array $config)
    {
        $dsn = "mysql:dbname={$config['database']};host={$config['host']}";
        //$connection = new PDO(
        //    $dsn,
        //    $config['user'],
        //    $config['password'],
        // );
        $connection = new PDO('sss');
    }
}
