<?php
require __DIR__ . '/includes/config.php';
require __DIR__ . '/includes/functions.php';

if (!is_logged_in()) {
    redirect('login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'description' => $_POST['description'],
        'amount' => (float)$_POST['amount'],
        'category' => $_POST['category'],
        'type' => $_POST['type']
    ];

    if (add_transaction($pdo, $_SESSION['user_id'], $data)) {
        $_SESSION['success'] = "Transaction added successfully!";
        redirect('dashboard.php');
    } else {
        $error = "Failed to add transaction";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Same head as dashboard -->
</head>
<body>
    <!-- Same sidebar as dashboard -->
    
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Add Transaction</h1>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="type">Transaction Type</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="income">Income</option>
                    <option value="expense">Expense</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description" required>
            </div>
            
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
            </div>
            
            <div class="form-group">
                <label for="category">Category</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="salary">Salary</option>
                    <option value="food">Food</option>
                    <option value="transport">Transport</option>
                    <option value="entertainment">Entertainment</option>
                    <option value="other">Other</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary mt-3">Add Transaction</button>
        </form>
    </main>
</body>
</html>