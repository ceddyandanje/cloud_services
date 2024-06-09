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
        echo "<p>Service request submitted!</p>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$requests = $conn->query("SELECT * FROM service_requests WHERE user_id = '$user_id'");
include('header.php');
?>

<h2>Welcome, <?php echo $user['name']; ?></h2>
<p>Current Time: <span id="current_time"></span></p>
<form method="POST">
    <label for="service_type">Choose a service:</label>
    <select name="service_type" id="service_type" required>
        <option value="VM" data-cost="10">VM - $10</option>
        <option value="App" data-cost="20">App - $20</option>
        <option value="Storage" data-cost="5">Storage - $5</option>
    </select>
    <input type="hidden" name="cost" id="cost" value="10">
    <button type="submit">Submit</button>
</form>
<h2>Your Requests</h2>
<ul>
    <?php while ($row = $requests->fetch_assoc()) { ?>
        <li><?php echo $row['service_type'] . ' - $' . $row['cost'] . ' - ' . $row['status']; ?></li>
    <?php } ?>
</ul>

<?php include('footer.php'); ?>
