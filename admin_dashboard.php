<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "cloud_services");

$result = $conn->query("SELECT sr.*, u.name, u.email FROM service_requests sr JOIN users u ON sr.user_id = u.id WHERE sr.status = 'Pending'");

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
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Admin Dashboard</h1>
    <h2>Pending Requests</h2>
    <ul>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <li>
                <?php echo $row['name'] . ' (' . $row['email'] . ') requested ' . $row['service_type'] . ' costing ' . $row['cost']; ?>
                <form method="POST">
                    <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="action" value="provision">Provision</button>
                    <button type="submit" name="action" value="reject">Reject</button>
                </form>
            </li>
        <?php } ?>
    </ul>
</body>
</html>
