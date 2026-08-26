<?php
session_start();

$response = ['loggedIn' => false];

if (isset($_SESSION['user_id'])) {
    $response['loggedIn'] = true;
    $response['firstName'] = $_SESSION['first_name'];
}

echo json_encode($response);
?>
