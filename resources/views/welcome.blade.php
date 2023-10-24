<!DOCTYPE html>
<html>
<head>
    <title>Currency Converter</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
<h1>Currency Converter</h1>

<div>
    <label for="source_currency">Source Currency:</label>
    <select id="source_currency">
        <option value="" selected>Select currency</option>
        <!-- Options will be added dynamically via JavaScript -->
    </select>
</div>

<div>
    <label for="target_currency">Target Currency:</label>
    <select id="target_currency">
        <option value="" selected>Select currency</option>
        <!-- Options will be added dynamically via JavaScript -->
    </select>
</div>

<div>
    <label for="amount">Amount:</label>
    <input type="text" id="amount">
</div>

<!-- Section to convert and display result -->
<button id="convertButton">Convert</button>

<div id="conversionResult"></div>

<br>

<!-- Section for displaying conversion history -->
<div>
    <button id="showHistoryButton">Show Conversion History</button>
    <div id="conversionHistory"></div>
</div>

<script>
    // Function to fetch currencies from the API and populate dropdowns
    function fetchCurrencies() {
        axios.get('/api/currencies/getAllCurrencies')
            .then(response => {
                const currencies = response.data;
                const sourceCurrencySelect = document.getElementById('source_currency');
                const targetCurrencySelect = document.getElementById('target_currency');

                currencies.forEach(currency => {
                    // Extract code and description from each currency object
                    const currencyValue = currency.value;
                    const currencyDescription = currency.description;

                    // Create an option element with both code and description
                    const option = document.createElement('option');
                    option.value = currencyValue;
                    option.text = `${currencyValue} - ${currencyDescription}`;
                    sourceCurrencySelect.appendChild(option);

                    // Clone the option element for the target currency dropdown
                    const optionCopy = option.cloneNode(true);
                    targetCurrencySelect.appendChild(optionCopy);
                });
            })
            .catch(error => {
                console.error(error);
            });
    }

    // Function to handle currency conversion
    function convertCurrency() {
        const sourceCurrency = document.getElementById('source_currency').value;
        const targetCurrency = document.getElementById('target_currency').value;
        const amount = document.getElementById('amount').value;

        axios.post('/api/currencies/covertCurrency', {
            source_currency: sourceCurrency,
            target_currency: targetCurrency,
            value: amount
        })
            .then(response => {
                const conversionResult = response.data;
                const resultDiv = document.getElementById('conversionResult');
                resultDiv.innerHTML = conversionResult.message;
            })
            .catch(error => {
                console.error(error);
            });
    }

    // Function to fetch and display conversion history
    function showConversionHistory() {
        axios.get('/api/currencies/conversions')
            .then(response => {
                const conversionHistory = response.data;
                const historyDiv = document.getElementById('conversionHistory');
                historyDiv.innerHTML = '<h2>Conversion History</h2>';
                if (conversionHistory.length === 0) {
                    historyDiv.innerHTML += '<p>No conversion history available.</p>';
                } else {
                    conversionHistory.forEach((record, index) => {
                        historyDiv.innerHTML += `<p><strong>Conversion ${index + 1}</strong></p>`;
                        historyDiv.innerHTML += `<p>Source Currency: ${record.source_currency_value} - ${record.source_currency_description}</p>`;
                        historyDiv.innerHTML += `<p>Value: ${record.source_currency_amount}</p>`;
                        historyDiv.innerHTML += `<p>Target Currency: ${record.target_currency_value} - ${record.target_currency_description}</p>`;
                        historyDiv.innerHTML += `<p>Converted Value: ${record.target_currency_amount}</p>`;
                        historyDiv.innerHTML += `<p>Conversion Date: ${record.created_at}</p>`;
                    });
                }
            })
            .catch(error => {
                console.error(error);
            });
    }

    // Attach event listeners
    const convertButton = document.getElementById('convertButton');
    convertButton.addEventListener('click', convertCurrency);

    const showHistoryButton = document.getElementById('showHistoryButton');
    showHistoryButton.addEventListener('click', showConversionHistory);


    // Fetch the list of currencies when the page loads
    fetchCurrencies();


</script>
</body>
</html>
