<?php
$servername = "localhost";
$username = "root";
$password = "root"; // รหัสผ่านเริ่มต้นของ MAMP
$dbname = "documents_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    //echo "Connected successfully!";
}
@session_start();
?>
