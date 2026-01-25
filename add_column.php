<?php
require 'vendor/autoload.php';
$db = \Config\Database::connect();
try {
    $db->query("ALTER TABLE pengeluaran ADD COLUMN status ENUM('dibayar', 'pending') DEFAULT 'dibayar' AFTER bukti");
    echo "Column added successfully";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
