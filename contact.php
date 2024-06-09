<?php
session_start();
include('header.php');
?>

<h2>Contact Us</h2>
<p>For any inquiries, please email us at ceddyandanje@gmail.com or call us at (2547) 914-05806. We look forward to hearing from you!</p>

<div class="contact-form">
    <h3>Send Us a Message</h3>
    <form method="POST" action="send_message.php">
        <label>Name:</label><input type="text" name="name" required><br>
        <label>Email:</label><input type="email" name="email" required><br>
        <label>Message:</label><textarea name="message" required></textarea><br>
        <button type="submit">Send</button>
    </form>
</div>

<?php include('footer.php'); ?>
