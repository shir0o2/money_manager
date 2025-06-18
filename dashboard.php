<?php
// Debugging - cek path config.php
$configPath = __DIR__ . '/includes/config.php';
if (!file_exists($configPath)) {
    die('Config file not found at: ' . $configPath);
}
require $configPath;

// Pastikan functions.php juga diinclude
$functionsPath = __DIR__ . '/includes/functions.php';
if (file_exists($functionsPath)) {
    require $functionsPath;
}

if (!is_logged_in()) {
    redirect('login.php');
}

// Get user transactions
$stmt = $pdo->prepare("SELECT * FROM transactions WHERE user_id = ? ORDER BY date DESC");
$stmt->execute([$_SESSION['user_id']]);
$transactions = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Money Manager Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block bg-dark sidebar">
                <div class="sidebar-sticky">
                    <h4 class="text-white p-3">Money Manager</h4>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="add_transaction.php">Add Transaction</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="transactions.php">View Transactions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>

                <!-- Summary Cards -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Income</h5>
                                <p class="card-text">$<?= number_format(get_total_income($pdo, $_SESSION['user_id']), 2) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-danger mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Expenses</h5>
                                <p class="card-text">$<?= number_format(get_total_expenses($pdo, $_SESSION['user_id']), 2) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Balance</h5>
                                <p class="card-text">$<?= number_format(get_balance($pdo, $_SESSION['user_id']), 2) ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions -->
                <h4>Recent Transactions</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $transaction): ?>
                            <tr>
                                <td><?= date('M d, Y', strtotime($transaction['date'])) ?></td>
                                <td><?= htmlspecialchars($transaction['description']) ?></td>
                                <td><?= htmlspecialchars($transaction['category']) ?></td>
                                <td class="<?= $transaction['type'] === 'income' ? 'text-success' : 'text-danger' ?>">
                                    <?= $transaction['type'] === 'income' ? '+' : '-' ?>
                                    $<?= number_format($transaction['amount'], 2) ?>
                                </td>
                                <td><?= ucfirst($transaction['type']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
<?php
echo '<pre>';
echo 'Current directory: ' . __DIR__ . "\n";
echo 'Config path: ' . __DIR__ . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'config.php' . "\n";
echo 'File exists: ' . (file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'config.php') ? 'YES' : 'NO') . "\n";

// List files in includes directory
$includesPath = __DIR__ . DIRECTORY_SEPARATOR . 'includes';
if (is_dir($includesPath)) {
    echo "Files in includes directory:\n";
    print_r(scandir($includesPath));
} else {
    echo "Includes directory not found!\n";
}
exit;