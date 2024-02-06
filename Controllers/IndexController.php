<?php

require "QueryController.php";

session_start();

try {
    $pdo = require 'database/db_connect.php';
} catch (\PDOException $e) {
    die('Подключение не удалось: ' . $e->getMessage());
}

//Инициализация класса контроллера запросов
$api = new \Controllers\QueryController();

$stories = $api->getStories($pdo);

include 'src/view/index.php';


