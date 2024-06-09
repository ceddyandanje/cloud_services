<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "cloud_services");

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT name FROM users WHERE id = '$user_id'");
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $service_type = $_POST['service_type'];
    $cost = $_POST['cost'];
    $sql = "INSERT INTO service_requests (user_id, service_type, cost) VALUES ('$user_id', '$service_type', '$cost')";

    if ($conn->query($sql) === TRUE) {
        echo "Service request submitted!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$requests = $conn->query("SELECT * FROM service_requests WHERE user_id = '$user_id'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        function displayTime() {
            var now = new Date();
            var hours = now.getHours();
            var minutes = now.getMinutes();
            var seconds = now.getSeconds();
            document.getElementById('current_time').innerHTML = hours + ':' + minutes + ':' + seconds;
            setTimeout(displayTime, 1000);
        }
        window.onload = displayTime;
    </script>
</head>
<body>
    <h1>Welcome, <?php echo $user['name']; ?></h1>
    <p>Current Time: <span id="current_time"></span></p>
    <form method="POST">
        <label for="service_type">Choose a service:</label>
        <select name="service_type" id="service_type" required>
            <option value="VM">VM - $10</option>
            <option value="App">App - $20</option>
            <option value="Storage">Storage - $5</option>
        </select>
        <input type="hidden" name="cost" id="cost" value="10">
        <button type="submit">Submit</button>
    </form>
    <h2>Your Requests</h2>
    <ul>
        <?php while ($row = $requests->fetch_assoc()) { ?>
            <li><?php echo $row['service_type'] . ' - ' . $row['cost'] . ' - ' . $row['status']; ?></li>
        <?php } ?>
    </ul>
</body>
</html>
