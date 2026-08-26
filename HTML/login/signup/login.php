<?php

ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); 

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myapp";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_POST['email'], $_POST['password'])) {
    echo "❌ Missing email or password.";
    exit;
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM appusers WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['email'] = $user['email'];
        
       
        header("Location: /myapp/UniHackProiectul/HTML/test_main.html");
        exit;
    } else {
        echo "❌ Incorrect password.";
    }
} else {
    echo "❌ No user found with that email.";
}

$conn->close();
?>
