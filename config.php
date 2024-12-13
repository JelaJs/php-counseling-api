<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
//ovaj config fajl nece biti samo za db vec za celu nasu app, tako da cemo napraviti key za svaku od konfiguracia
return [
    'database' => [
     'host' => $_ENV["DB_HOST"],
     'port' => $_ENV["DB_PORT"],
     'dbname' => $_ENV["DB_NAME"],
     'charset' => $_ENV["DB_CHARSET"]
    ]
 ];