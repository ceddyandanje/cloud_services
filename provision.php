<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "cloud_services");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request_id = $_POST['request_id'];
    $action = $_POST['action'];
    $status = $action == 'provision' ? 'Provisioned' : 'Rejected';
    $conn->query("UPDATE service_requests SET status = '$status' WHERE id = '$request_id'");
    header('Location: admin_dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Provision Service</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Service Provision</h2>
    <form method="POST">
        <label>Request ID:</label><input type="text" name="request_id" required><br>
        <label>Action:</label>
        <select name="action" required>
            <option value="provision">Provision</option>
            <option value="reject">Reject</option>
        </select><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
