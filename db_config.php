<?php
$host = 'localhost';
$username_db = 'root'; 
$password_db = '';     
$database = 'proyek_web_b'; 

$conn = new mysqli($host, $username_db, $password_db, $database);

if ($conn->connect_error) {
    die("Koneksi Database Gagal: " . $conn->connect_error);
}
?>