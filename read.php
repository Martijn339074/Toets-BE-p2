<?php

/**
 * Haal de inloggegevens binnen op deze pagina met de include functie
 * haal daarmee het bestand config.php binnen met de inloggegevens
 */
include('config/config.php');

/**
 * Maak een datasourcename-string voor het maken van een PDO-object
 * Let erop dat host en dbname klein geschreven zijn.
 */
$dsn = "mysql:host=$dbHost;
        dbname=$dbName;
        charset=UTF8;";

/**
 * Maak een nieuw PDO-object om de verbinding te maken met de database op
 * de mysql-server
 */
$pdo = new PDO($dsn, $dbUser, $dbPass);

/**
 * Maak een SELECT-query voor het opvragen van de data uit de databasetabel
 * Gebruik voor het sorteren ORDER BY voor oplopen (ASC) voor aflopend (DESC)
 */
$sql = "SELECT Id
              ,Voornaam
              ,Tussenvoegsel
              ,Achternaam
              ,Wachtwoord
        FROM  Persoon
        ORDER BY Achternaam ASC";

/**
 * Maak de query geschikt voor PDO met de functie prepare
 */
$statement = $pdo->prepare($sql);

/**
 * Voer de query uit op de database
 */
$statement->execute();

/**
 * Met de fetchAll method stoppen we de geselecteerde records als object in een 
 * array.
 */
$result = $statement->fetchAll(PDO::FETCH_OBJ);


/**
 * Het indexed-array $result met daarin objecten doorlopen we met een foreach-loop
 */
$tableRows = "";
foreach ($result as $persoonObject) {
    $tableRows .= "<tr>
                        <td>$persoonObject->Voornaam</td>
                        <td>$persoonObject->Tussenvoegsel</td>
                        <td>$persoonObject->Achternaam</td>
                        <td>$persoonObject->Wachtwoord</td>
                        <td>
                           <a href='update.php?id=$persoonObject->Id'> 
                                <img src='img/edit.png' alt='potlood'>
                           </a>
                        </td>
                    </tr>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <title>CRUD</title>
</head>
<body>
    <h3>Persoonsgegevens</h3>

    <!-- Maak een HTML tabel -->

    <table>
        <thead>
            <th>Voornaam</th>
            <th>Tussenvoegsel</th>
            <th>Achternaam</th>
            <th>Wachtwoord</th>
            <th>Wijzigen</th>
        </thead>
        <tbody>
            <?php echo $tableRows; ?>
        </tbody>
    </table>
</body>
</html>