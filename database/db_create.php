<?php

// Подключение к базе данных
try {
    $pdo = require 'db_connect.php';
} catch (\PDOException $e) {
    die('Подключение не удалось: ' . $e->getMessage());
}

// Функция для выполнения SQL-запроса
function executeQuery($pdo, $query) {
    try {
        $pdo->exec($query);
        echo "База данных успешно создана.\n";
    } catch (\PDOException $e) {
        echo "Error executing query: " . $e->getMessage() . "\n";
    }
}
