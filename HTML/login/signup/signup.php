<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myapp";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$countryCity = $_POST['country_city'];
$passwordPlain = $_POST['password'];
$hashedPassword = password_hash($passwordPlain, PASSWORD_DEFAULT);


$check = $conn->prepare("SELECT id FROM appusers WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    echo "Email already exists. Please <a href='login.html'>log in</a>.";
    $check->close();
    $conn->close();
    exit;
}
$check->close();


$stmt = $conn->prepare("INSERT INTO appusers (first_name, last_name, email, password, phone, country_city, score) VALUES (?, ?, ?, ?, ?, ?, 0)");
$stmt->bind_param("ssssss", $firstName, $lastName, $email, $hashedPassword, $phone, $countryCity);

if ($stmt->execute()) {
    
    $_SESSION['user_id'] = $stmt->insert_id;
    $_SESSION['first_name'] = $firstName;
    $_SESSION['email'] = $email;

   
    header("Location: /myapp/UniHackProiectul/HTML/profile.php");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
