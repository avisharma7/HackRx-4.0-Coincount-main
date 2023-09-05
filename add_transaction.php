<?php
$host = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'coincount';

session_start();
$email=$_SESSION['email'];

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$description = $_POST['description'];
$amount = $_POST['amount'];
$month = $_POST['month'];


$sql = "INSERT INTO transactions (email,description, amount,month) VALUES ('$email','$description', '$amount','$month')";
if ($conn->query($sql) === TRUE) {
  
    header("Location: main.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();
?>
