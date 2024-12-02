<?php
include 'auth.php'; // Ensure the user is logged in
include 'db_connect.php';

// Fetch waste data from the database for the logged-in user
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT category, SUM(amount) as total_amount FROM wastes WHERE user_id = :user_id GROUP BY category");
$stmt->execute(['user_id' => $user_id]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for the chart
$categories = [];
$amounts = [];
foreach ($data as $row) {
    $categories[] = $row['category'];
    $amounts[] = $row['total_amount'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Dashboard</title>
</head>
<body>
    <div class="container">
        <aside>
            <h2>Trust Fund</h2>
            <nav>
                <ul>
                    <li><a href="your_wastes.php">Your Wastes</a></li>
                    <li><a href="dashboard.php" class="active">Dashboard</a></li>
                    <li><a href="account_settings.php">Account Settings</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </nav>
        </aside>
        <main>
            <div class="welcome-message">
                <p>Welcome back, <?= htmlspecialchars($_SESSION['first_name'] ?? $_SESSION['email']) ?>!</p>
            </div>
            <canvas id="wasteChart"></canvas>
        </main>
    </div>

    <script>
        const ctx = document.getElementById('wasteChart').getContext('2d');
        const wasteChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($categories) ?>,
                datasets: [{
                    label: 'Waste Amount (€)',
                    data: <?= json_encode($amounts) ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</body>
</html>
