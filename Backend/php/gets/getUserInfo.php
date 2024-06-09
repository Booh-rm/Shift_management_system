<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['type' => 'error', 'message' => 'User not logged in']);
    exit();
}

$response = [
    'type' => 'success',
    'user_name' => $_SESSION['user_name'],
    'user_lastname' => $_SESSION['user_lastname'],
    'email' => $_SESSION['email']
];

echo json_encode($response);
?>
