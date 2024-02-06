
// document.addEventListener('DOMContentLoaded', function () {
//     // Загрузка данных для отображения в таблице при загрузке страницы
//     loadGiftCards();
// });

const statusSelect = document.getElementById('status');
const usedOption = document.querySelector('.used-option');
// Обработчик события change status->used
statusSelect.addEventListener('change', function() {
    if (statusSelect.value === 'used') {
        usedOption.style.display = 'block';
    } else {
        usedOption.style.display = 'none';
    }
});

// Функция для загрузки данных с сервера
function loadData(url, callback) {

    // Отображение анимации загрузки
    const loadingDiv = document.getElementById('loading');
    loadingDiv.style.display = 'block';

    fetch(url)
        .then(response => response.json())
        .then(data => {
            // Скрытие анимации загрузки после получения данных
            loadingDiv.style.display = 'none';
            callback(data);
        })
        .catch(error => {
            console.error('Error:', error);
            // Скрытие анимации в случае ошибки
            loadingDiv.style.display = 'none';
        });
}



function loadGiftCards() {
    const status = document.getElementById('status').value;
    const start = document.getElementById('start').value;
    const end = document.getElementById('end').value;
    const store = document.getElementById('store').value;

    // Функция для отображения данных в таблице
    function displayDataInTable(data) {
        const tableBody = document.querySelector('#giftCardTable tbody');
        tableBody.innerHTML = '';

        data.forEach(card => {
            const row = document.createElement('tr');
            row.innerHTML = `
                        <td xmlns="http://www.w3.org/1999/html">${card.card_number}</td>
                        <td>${card.nominal}</td>
                        <td>${card.usage_date}</td>
                        <td>${card.store_name}</td>
                        <td>${card.receipt_number}</td>
                        <td class="card-details-btn" onclick="showCardDetails(${card.card_number})">Просмотр</td>
                    `;
            tableBody.appendChild(row);
        });
    }

    if (status !== "choose") {
        // Загрузка данных с сервера с учетом выбранных фильтров
        loadData(`api?status=${status}&start=${start}&end=${end}&storeId=${store}`, displayDataInTable);
    }
}

// Функция получения данных для отображения деталей использования карты
function showCardDetails(cardNumber) {
    const detailsDialog = document.getElementById('cardDetailsDialog');
    // detailsDialog.style.display = 'block';
    detailsDialog.showModal();

    // Загрузка детальной информации о карте
    loadData(`api?cardNumber=${cardNumber}`, displayCardDetails);
}

// Функции отображения деталей использования карты
function displayCardDetails(cardDetails) {
    document.getElementById('cardNumber').textContent = cardDetails[0].card_number;
    document.getElementById('nominal').textContent = cardDetails[0].nominal;
    document.getElementById('notSpent').textContent = (cardDetails[0].nominal - cardDetails[0].total_cost);
    document.getElementById('usageDate').textContent = cardDetails[0].usage_date;
    document.getElementById('storeName').textContent = cardDetails[0].store_name;
    document.getElementById('receiptNumber').textContent = cardDetails[0].receipt_number;

    // Отображение состава кассового документа
    displayReceiptDetails(cardDetails);
}

function displayReceiptDetails(cardDetails) {
    const receiptTableBody = document.querySelector('#receiptTable tbody');
    receiptTableBody.innerHTML = '';

    cardDetails.forEach(item => {
        const row = document.createElement('tr');
        row.innerHTML = `
                    <td>${item.position}</td>
                    <td>${item.product_name}</td>
                    <td>${item.unit_of_measurement}</td>
                    <td>${item.quantity}</td>
                    <td>${item.price}</td>
                    <td>${item.total_cost}</td>
                `;
        receiptTableBody.appendChild(row);
    });
}

//Фунукция закрытия диалогового окна
function closeCardDetails() {
    const detailsDialog = document.getElementById('cardDetailsDialog');
    // detailsDialog.style.display = 'none';
    detailsDialog.close();
}