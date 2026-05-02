<?php
require_once 'includes/config.php';
$stmt = $pdo->query("SELECT id, name, category FROM recipes");
while ($row = $stmt->fetch()) {
    echo "ID: " . $row['id'] . " | Name: " . $row['name'] . " | Category: " . $row['category'] . "\n";
}
?>
