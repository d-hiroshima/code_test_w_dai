document.getElementById('deliveryAreaSelect').addEventListener('change', function() {
    const deliveryArea = this.value;

    // 配送希望日のselect
    const deliveryDateSelect = document.getElementById('deliveryDateSelect');

    // 非同期で日付の変更
    fetch('/delivery-dates/' + encodeURIComponent(deliveryArea))
        .then(response => response.json())
        .then(dates => {
            deliveryDateSelect.innerHTML = '';

            dates.forEach(date => {
                var option = document.createElement('option');
                option.value = date;
                option.text = date;
                deliveryDateSelect.appendChild(option);
            });
        });
});
