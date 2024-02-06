<?php

namespace Controllers;

class QueryController
{
    // Метод для получения списка подарочных карт по фильтрам
    function getGiftCards($status, $usagePeriod, $storeId, $pdo)
    {
        $query = "SELECT gc.card_number, gc.nominal, gc.usage_date, s.store_name, gc.receipt_number
              FROM GiftCard gc
              LEFT JOIN Store s ON gc.store_id = s.store_id
              WHERE ";

        switch ($status) {
            case 'issued':
                $query .= "gc.card_number IS NOT NULL";
                break;
            case 'unused':
                $query .= "gc.usage_date IS NULL";
                break;
            case 'used':
                $query .= "gc.usage_date IS NOT NULL";
                break;
        }

        if ($usagePeriod['start'] !== "") {
            if ($usagePeriod['end'] == "") {
                $usagePeriod['end'] = date('Y-m-d'); // Если конечная дата не выбрана подставляем дату сегодня
            }
            $query .= " AND (DATE(gc.usage_date) BETWEEN ? AND ?)";
        }

        if ($storeId != 'all') {
            $query .= " AND gc.store_id = ? ";
        }

        $stmt = $pdo->prepare($query);

        if ($status === 'used' && $usagePeriod['start'] !== "" && $usagePeriod['end'] !== "") {
            if ($storeId == 'all') {
                $stmt->execute([$usagePeriod['start'], $usagePeriod['end']]);
            } else {
                $stmt->execute([$usagePeriod['start'], $usagePeriod['end'],$storeId]);
            }
        } elseif ($storeId != 'all') {
//            die($query);
            $stmt->execute([$storeId]);
        } else {
//            die($query);
            $stmt->execute();

        }

        return $stmt->fetchAll();
    }

    // Метод для получения информации об использованной карте
    function getUsedCardInfo($cardNumber, $pdo)
    {
        $query = "SELECT gc.card_number, gc.nominal, gc.usage_date, s.store_name, gc.receipt_number,
                     r.position, r.product_name, r.unit_of_measurement, r.quantity, r.price, r.total_cost
              FROM GiftCard gc
              LEFT JOIN Store s ON gc.store_id = s.store_id
              LEFT JOIN Receipt r ON gc.receipt_number = r.receipt_number
              WHERE gc.card_number = ?";

        $stmt = $pdo->prepare($query);
        $stmt->execute([$cardNumber]);

        return $stmt->fetchAll();
    }

    //Метод для получения информации о всех магазинах
    function getStories($pdo)
    {
        $query = "SELECT * FROM Store";
        $stmt = $pdo->query($query);

        return $stmt->fetchAll();
    }

}