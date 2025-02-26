<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Electrician by City</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <!-- font awesome style -->
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="css/responsive.css" rel="stylesheet" />
    <style>
        /* Fade-in Animation */
        .animate-fade-in {
            animation: fadeIn 0.7s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="text-center mt-12">
        <h1 class="text-4xl font-extrabold mb-6 text-pink-600">Search Electrician by City</h1>

        <!-- Search Form -->
        <div class="relative w-full max-w-3xl mx-auto">
            <input type="text" id="cityInput" placeholder="Enter city name"
                class="w-full py-3 pl-4 pr-12 rounded-full bg-cyan-500 text-white focus:outline-none">
            <button onclick="fetchElectricians()"
                class="absolute right-0 top-0 mt-1.5 mr-1.5 w-10 h-10 rounded-full bg-pink-500 flex items-center justify-center text-white">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>

    <!-- Dynamic Result Section -->
    <div id="results" class="max-w-4xl mx-auto mt-12 w-full"></div>

    <!-- AJAX Script -->
    <script>
        // Fetch and display electricians by city
        function fetchElectricians() {
            const city = document.getElementById('cityInput').value.trim();
            const resultsDiv = document.getElementById('results');

            if (city === '') {
                resultsDiv.innerHTML = '<p class="text-center text-gray-700 mt-12">Please enter a city.</p>';
                return;
            }

            // Fetch data via AJAX
            fetch(`fetcheledata.php?city=${encodeURIComponent(city)}`)
                .then(response => response.text())
                .then(data => {
                    resultsDiv.innerHTML = data;
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    resultsDiv.innerHTML = '<p class="text-center text-red-500 mt-12">Error fetching data.</p>';
                });
        }

        // Trigger search on Enter key
        document.getElementById('cityInput').addEventListener('keyup', function (event) {
            if (event.key === 'Enter') {
                fetchElectricians();
            }
        });
    </script>
</body>

</html>