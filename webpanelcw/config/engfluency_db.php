<?php
$servername = "localhost";
$username = "root";
$password = "";
// $username = "engfluency56_db";
// $password = "9m4zPzBEQs";

try {
  $conn = new PDO("mysql:host=$servername;dbname=engfluency_db;charset=utf8", $username, $password);
  // $conn = new PDO("mysql:host=$servername;dbname=engfluency56_db;charset=utf8", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 //echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
