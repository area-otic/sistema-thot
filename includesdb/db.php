<?php

$host = 'localhost';
$dbname = 'thot_data_db';
$username = 'root'; // Cambia esto si es necesario
$password = ''; // Cambia esto si es necesario

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>