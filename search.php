<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$host = "localhost";
$user = "root";
$password = "12345678"; // Replace with your database password
$dbname = "blog_search";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle search query
$query = isset($_GET['query']) ? $_GET['query'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

$sql = "SELECT * FROM blogs WHERE (title LIKE ? OR content LIKE ?)";
$params = ["%$query%", "%$query%"];

if (!empty($category)) {
    $sql .= " AND category = ?";
    $params[] = $category;
}

// Prepare and execute statement
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat("s", count($params)), ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Fetch results
$blogs = [];
while ($row = $result->fetch_assoc()) {
    $blogs[] = $row;
}

$stmt->close();
$conn->close();

// Return results as JSON
header('Content-Type: application/json');
echo json_encode($blogs);

