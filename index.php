<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "kiriti_girls_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("connection failed:" . $conn->connect_error);
} else {
    echo "Database connection successful!";
}
?>
<h1>Welcome to the Kiriti Girls Information System</h1>
<p>This system allows Admins to send notificaton to parents</p>
<a href="login.php">Login as Admin</a>
</body>

</html>