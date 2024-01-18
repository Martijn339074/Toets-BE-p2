<?php
// create.php

include 'config/config.php'; // Voeg een configuratiebestand toe met database-inloggegevens

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $name = $_POST['name'];
        $networth = $_POST['networth'];
        $age = $_POST['age'];
        $myCompany = $_POST['myCompany'];

        // Gebruik placeholders in de query om SQL-injectie te voorkomen
        $query = "INSERT INTO RichestPeople (Name, Networth, Age, MyCompany) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$name, $networth, $age, $myCompany]);

        echo "Nieuw record is toegevoegd!";
        header("refresh:2.5;url=index.php"); // Herleid na 2.5 seconden naar index.php
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Record</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Create New Record</h2>
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="networth">Net Worth:</label>
        <input type="text" id="networth" name="networth" required><br>

        <label for="age">Age:</label>
        <input type="text" id="age" name="age" required><br>

        <label for="myCompany">My Company:</label>
        <input type="text" id="myCompany" name="myCompany" required><br>

        <button type="submit">Add Record</button>
    </form>
</body>
</html>
