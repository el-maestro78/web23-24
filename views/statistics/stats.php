<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Statistics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include '../toolbar.php'; ?>
<h2>Statistics</h2>
<form id="dateForm">
    Start Date: <input type="date" id="startDate" name="start_date" required>
    End Date: <input type="date" id="endDate" name="end_date" required>
    <button type="submit">Show Statistics</button>
</form>

<canvas id="myChart" width="400" height="200"></canvas>

<script>
    document.getElementById('dateForm').addEventListener('submit', function (event) {
        event.preventDefault();
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

        fetch('../../controller/fetch_statistics.php', {
            method: 'POST',
            body: `start_date=${startDate}&end_date=${endDate}`,
        })
        .then(response => response.json())
        .then(data => {
            // Update Chart.js with new data
            const ctx = document.getElementById('myChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['New Requests', 'New Offers', 'Completed Requests', 'Completed Offers'],
                    datasets: [{
                        label: 'Count',
                        data: [data.new_requests, data.new_offers, data.completed_requests, data.completed_offers],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error:', error));
    });
</script>

</body>
</html>
