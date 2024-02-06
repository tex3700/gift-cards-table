<?php

require_once 'db_create.php';

// Заполнение таблиц тестовыми данными
$insertTestDataQuery = "
    INSERT INTO Store (store_name) VALUES
        ('Магазин A'),
        ('Магазин B'),
        ('Магазин C');

    INSERT INTO Receipt (receipt_number, position, product_name, unit_of_measurement, quantity, price) VALUES
        (12345, 1, 'Produduct 1', 'шт', 2, 25),
        (23456, 1, 'Produduct 2', 'кг', 1, 50),
        (34567, 3, 'Produduct 3', 'шт', 3, 30);

    INSERT INTO GiftCard (card_number, nominal, usage_date, store_id, receipt_number) VALUES
        (11111, 1000, NULL, NULL, NULL),
        (22222, 500, '2023-01-15', 2, 23456),
        (33333, 2000, '2023-02-20', 3, 34567),
        (44444, 1000, '2024-01-03', 1, 12345);
";

executeQuery($pdo, $insertTestDataQuery);
