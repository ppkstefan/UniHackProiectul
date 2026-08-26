<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: \\myapp\\UniHackProiectul\\HTML\\login\\signup\\login.html");
    exit;
}

$firstName = htmlspecialchars($_SESSION['first_name']);
$email = htmlspecialchars($_SESSION['email']);
$userId = $_SESSION['user_id'];


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myapp";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$score = 0;
$sql = "SELECT score FROM appusers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $score = $row['score'];
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Profile | HustleWords</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background: #fff9f2;
    }
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #ffffffcc;
      padding: 20px 40px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      position: sticky;
      top: 0;
      z-index: 1000;
    }
    .navbar h1 {
      font-size: 24px;
      font-weight: 800;
      color: #f44369;
      margin: 0;
    }
    .navbar a {
      text-decoration: none;
      color: #333;
      font-weight: 600;
      margin-left: 20px;
    }
    .navbar a:hover { color: #f44369; }

    .profile-container {
      background: white;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 12px 32px rgba(0, 0, 0, 0.08);
      display: flex;
      gap: 40px;
      max-width: 960px;
      margin: 80px auto;
      align-items: center;
    }
    .profile-image {
      width: 280px;
      max-height: 320px;
    }
    .profile-info {
      flex: 1;
    }
    h2 {
      font-size: 32px;
      margin-bottom: 20px;
      font-weight: 800;
      color: #333;
    }
    p {
      font-size: 18px;
      margin: 10px 0;
      color: #555;
    }
    .logout-btn {
      background: #f44369;
      color: white;
      border: none;
      padding: 12px 24px;
      font-weight: 700;
      border-radius: 12px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 20px;
      text-decoration: none;
      display: inline-block;
    }
    .logout-btn:hover { background: #e5395f; }
  </style>
</head>
<body>

  <nav class="navbar">
    <h1>HustleWords</h1>
    <div>
      <a href="\myapp\UniHackProiectul\HTML\test_main.html">Home</a>
      <a href="\myapp\UniHackProiectul\HTML\login\signup\logout.php" class="logout-btn">Log Out</a>
    </div>
  </nav>

  <div class="profile-container">
    <img class="profile-image" src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="User Icon">
    <div class="profile-info">
      <h2>Welcome, <?php echo $firstName; ?>!</h2>
      <p><strong>Email:</strong> <?php echo $email; ?></p>
      <p><strong>Status:</strong> Logged In</p>
      <p><strong>Score:</strong> <?php echo $score; ?></p>
    </div>
  </div>

</body>
</html>
