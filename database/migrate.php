<?php

require_once 'db_create.php';

// Создание таблиц в базе данных
$createTablesQuery = "
    CREATE TABLE IF NOT EXISTS Store (
        store_id INT AUTO_INCREMENT PRIMARY KEY,
        store_name VARCHAR(255) NOT NULL
    );

    CREATE TABLE IF NOT EXISTS Receipt (
        receipt_number INT PRIMARY KEY,
        position INT NOT NULL,
        product_name VARCHAR(255) NOT NULL,
        unit_of_measurement VARCHAR(50),
        quantity INT NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        total_cost DECIMAL(10, 2) GENERATED ALWAYS AS (quantity * price) STORED
    );

    CREATE TABLE IF NOT EXISTS GiftCard (
        card_number INT PRIMARY KEY,
        nominal DECIMAL(10, 2) NOT NULL,
        usage_date DATE,
        store_id INT,
        receipt_number INT,
        FOREIGN KEY (store_id) REFERENCES Store(store_id),
        FOREIGN KEY (receipt_number) REFERENCES Receipt(receipt_number)
    );

";

executeQuery($pdo, $createTablesQuery);
