<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = mysqli_connect("127.0.0.1", "root", "", "proiectphp", 3306, '/var/run/mysqld/mysqld.sock')
        or die("Nu s-a putut face conectarea la baza de date: " . mysqli_connect_error());
?>
