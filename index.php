<?php
// index.php

include 'config/config.php';

try {
    $pdo = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT * FROM RichestPeople ORDER BY Networth DESC";
    $stmt = $pdo->query($query);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Richest People</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Richest People</h2>

    <a href="create.php">Nieuw Record</a>

    <?php if (!empty($results)): ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Net Worth</th>
                <th>Age</th>
                <th>Company</th>
            </tr>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= $row['Id'] ?></td>
                    <td><?= $row['Name'] ?></td>
                    <td><?= $row['Networth'] ?></td>
                    <td><?= $row['Age'] ?></td>
                    <td><?= $row['MyCompany'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No records found.</p>
    <?php endif; ?>
</body>
</html>
