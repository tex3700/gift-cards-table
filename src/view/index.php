
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gift Cards</title>

    <link href="/src/css/styles.css" rel="stylesheet" type="text/css">

</head>
<body>

<!-- Анимация загрузки -->
    <div id="loading">Загрузка...</div>

    <h1>Подарочные карты</h1>
    <div class="gcContainer">
        <div class="gcFilterBar">
            <!-- Форма для выбора фильтров -->
            <form id="filterForm">
                <section>
                    <label for="status">Статус карты:</label>
                    <select id="status" name="status">
                        <option value="choose">Выбирите статус карты</option>
                        <option value="issued">Выпущена</option>
                        <option value="unused">Не использована</option>
                        <option value="used" >Использована</option>
                    </select>
                </section>

                <section class="used-option">
                    <h4>Период даты использования карты:</h4>
                    <div>
                        <label for="start">Начало периода:</label>
                        <input type="date" id="start" name="start">
                    </div>
                    <div>
                        <label for="end">Конец периода:</label>
                        <input type="date" id="end" name="end">
                    </div>
                    <div>
                        <label for="store"><strong>Магазины использования:</strong></label>
                        <div>
                            <select id="store" name="store">
                                <option value="all">Все магазины</option>
                                <?php include "src/stories.php"?>
                            </select>
                        </div>
                    </div>
                </section>

                <button type="button" class="gc-btn" onclick="loadGiftCards()">Применить</button>
            </form>
        </div>

        <div class="gcTableDashboard">
            <!-- Таблица подарочных карт -->
            <table id="giftCardTable">
                <thead>
                <tr>
                    <th>Номер карты</th>
                    <th>Номинал, руб.</th>
                    <th>Дата использования</th>
                    <th>Магазин использования</th>
                    <th>Кассовый документ, №</th>
                    <th>Детали использования карты</th>
                </tr>
                </thead>
                <tbody>
                <!-- Отображаемые данные -->
                </tbody>
            </table>
        </div>
    </div>
    <!-- Диалоговое окно с детальной информацией о карте -->
    <dialog id="cardDetailsDialog">
        <h3>Информация об использовании карты</h3>
        <p><strong>Номер карты:</strong>  <span id="cardNumber"></span></p>
        <p><strong>Номинал:</strong>  <span id="nominal"></span> руб.</p>
        <p><strong>Не использовано:</strong>  <span id="notSpent"></span> руб.</p>
        <p><strong>Дата использования:</strong>  <span id="usageDate"></span></p>
        <p><strong>Магазин использования:</strong>  <span id="storeName"></span></p>
        <p><strong>Номер кассового документа:</strong>  <span id="receiptNumber"></span></p>

        <!-- Таблица с составом кассового документа -->
        <h3>Состав кассового документа:</h3>
        <table id="receiptTable">
            <thead>
                <tr>
                    <th>№ позиции</th>
                    <th>Наименование товара</th>
                    <th>Ед-измерения</th>
                    <th>Кол-во</th>
                    <th>Цена</th>
                    <th>Стоимомсть</th>
                </tr>
            </thead>
            <tbody>
            <!-- Здесь отображаться состав кассового документа -->
            </tbody>
        </table>

        <button class="gc-btn" onclick="closeCardDetails()">Закрыть</button>
    </dialog>

    <script src="/src/js/form_control.js"></script>
    </body>
</html>
