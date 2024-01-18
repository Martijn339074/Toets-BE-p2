<?php
/**
 * Voeg de inloggegevens toe aan de pagina create.php
 * door het includen van config.php
 */
include('config/config.php');

/**
 * Maak een datasourcename string om mee te geven aan de 
 * de constructor van de PDO-class
 */
$dsn = "mysql:host=$dbHost;
        dbname=$dbName;
        charset=UTF8";

/**
 * Maak een nieuw object van de PDO-class om verbinding te maken met de
 * MySQL-database
 */
$pdo = new PDO($dsn, $dbUser, $dbPass);

/**
 * Het $_POST-array wordt schoongemaakt door een PHP-filter
 */
$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

/**
 * Maak een insert-query om de gegevens uit het formulier weg te schrijven naar
 * de database.
 */
$sql = "INSERT INTO RichtestPeople (Voornaam
                            ,Tussenvoegsel
                            ,Achternaam
                            ,Wachtwoord)
        VALUES              (:firstname
                            ,:infix
                            ,:lastname
                            ,:password)";


/**
 * Prepareer de sql-query met de prepare-method van de PDO class
 */
$statement = $pdo->prepare($sql);

/**
 * Verbind aan de placeholders de $_POST-waarden met de method bindValue()
 */
$statement->bindValue(':firstname', $_POST['firstname'], PDO::PARAM_STR);
$statement->bindValue(':infix', $_POST['infix'], PDO::PARAM_STR);
$statement->bindValue(':lastname', $_POST['lastname'], PDO::PARAM_STR);
$statement->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
/**
 * Voer de query uit op de database
 */
$statement->execute();

/**
 * Feedback voor de gebruikers dat het opslaan
 * gelukt is.
 */
echo "De gegevens zijn opgeslagen in de database";

/**
 * De header() functie stuurt de gebruiker naar een andere pagina. In 
 * dit geval na 3,5 seconden
 */
header('Refresh:3.5; url=index.php');

