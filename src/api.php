<?php

require '../Controllers/QueryController.php';

sleep(3); // Эмуляция задержки

// Подключение к базе данных
try {
    $pdo = require '../database/db_connect.php';
} catch (\PDOException $e) {
    die('Подключение не удалось: ' . $e->getMessage());
}

//Инициализация класса контроллера запросов
$api = new \Controllers\QueryController();

// Обработка запросов
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['status']) && in_array($_GET['status'], ['issued', 'unused', 'used'])) {
        $status = $_GET['status'];
        $usagePeriod = [
            'start' => $_GET['start'],
            'end'   => $_GET['end'],
        ];
        $storeId = $_GET['storeId'] ?? 'all';

        $giftCards = $api->getGiftCards($status, $usagePeriod, $storeId, $pdo);
        echo json_encode($giftCards);

    } elseif (isset($_GET['cardNumber']) && ctype_digit($_GET['cardNumber'])) {
        $cardNumber = $_GET['cardNumber'];
        $usedCardInfo = $api->getUsedCardInfo($cardNumber, $pdo);
        echo json_encode($usedCardInfo);

    } else {
        http_response_code(400); // Некорректный запрос
        echo json_encode(['error' => 'Invalid request']);
    }

} else {
    http_response_code(405); // Метод не поддерживается
    echo json_encode(['error' => 'Method not allowed']);
}

