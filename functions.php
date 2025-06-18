<?php
function get_total_income($pdo, $user_id) {
    $stmt = $pdo->prepare("SELECT SUM(amount) as total FROM transactions WHERE user_id = ? AND type = 'income'");
    $stmt->execute([$user_id]);
    return $stmt->fetch()['total'] ?? 0;
}

function get_total_expenses($pdo, $user_id) {
    $stmt = $pdo->prepare("SELECT SUM(amount) as total FROM transactions WHERE user_id = ? AND type = 'expense'");
    $stmt->execute([$user_id]);
    return $stmt->fetch()['total'] ?? 0;
}

function get_balance($pdo, $user_id) {
    return get_total_income($pdo, $user_id) - get_total_expenses($pdo, $user_id);
}

function add_transaction($pdo, $user_id, $data) {
    $stmt = $pdo->prepare("INSERT INTO transactions 
        (user_id, description, amount, category, type, date) 
        VALUES (?, ?, ?, ?, ?, ?)");
    
    return $stmt->execute([
        $user_id,
        $data['description'],
        $data['amount'],
        $data['category'],
        $data['type'],
        $data['date'] ?? date('Y-m-d')
    ]);
}