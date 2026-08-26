<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Not logged in."]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['correct_answers']) || !isset($input['total_attempts'])) {
    echo json_encode(["error" => "Invalid input data."]);
    exit;
}

$correctAnswers = intval($input['correct_answers']);
$totalAttempts = intval($input['total_attempts']);

if ($totalAttempts <= 0) {
    echo json_encode(["error" => "Total attempts must be greater than 0."]);
    exit;
}

$currentScore = ($correctAnswers / $totalAttempts) * 100;

$conn = new mysqli("localhost", "root", "", "myapp");
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}

$userId = $_SESSION['user_id'];


$stmt = $conn->prepare("SELECT score, score_count FROM appusers WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($existingScore, $scoreCount);
$stmt->fetch();
$stmt->close();


$existingScore = is_null($existingScore) ? 0.0 : floatval($existingScore);
$scoreCount = is_null($scoreCount) ? 0 : intval($scoreCount);


$newCount = $scoreCount + 1;
$newAverageScore = (($existingScore * $scoreCount) + $currentScore) / $newCount;


error_log("User: $userId | Existing Score: $existingScore | Existing Count: $scoreCount | New Score: $currentScore | Final Avg: $newAverageScore");


$update = $conn->prepare("UPDATE appusers SET score = ?, score_count = ? WHERE id = ?");
$update->bind_param("dii", $newAverageScore, $newCount, $userId);
$success = $update->execute();

if (!$success) {
    error_log("Update error: " . $update->error);
    echo json_encode(["error" => "Failed to update database."]);
    exit;
}

$update->close();
$conn->close();

echo json_encode([
    "success" => true,
    "updated_score" => round($newAverageScore, 2),
    "attempts" => $newCount
]);
