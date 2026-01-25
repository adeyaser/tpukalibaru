<?php
$mysqli = new mysqli("localhost", "root", "", "dbsimakam");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$sql = "ALTER TABLE pengeluaran ADD COLUMN status ENUM('dibayar', 'pending') DEFAULT 'dibayar' AFTER bukti";

if ($mysqli->query($sql)) {
    echo "Column 'status' added successfully to 'pengeluaran' table.";
} else {
    echo "Error: " . $mysqli->error;
}

$mysqli->close();
?>
