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
     * Hier checken we of er al op de submit button van het formulier is geklikt
     */
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // var_dump($_POST);

        /**
         * Maak een update query voor het updaten van alle records.
         */
        $sql = "UPDATE Persoon
                SET    Voornaam = :voornaam
                      ,Tussenvoegsel = :tussenvoegsel
                      ,Achternaam = :achternaam
                      ,Wachtwoord = :wachtwoord
                WHERE Id = :id";

        $statement = $pdo->prepare($sql);

        $statement->bindValue(':voornaam', $_POST['firstname'], PDO::PARAM_STR);
        $statement->bindValue(':tussenvoegsel', $_POST['infix'], PDO::PARAM_STR);
        $statement->bindValue(':achternaam', $_POST['lastname'], PDO::PARAM_STR);
        $statement->bindValue(':wachtwoord', $_POST['password'], PDO::PARAM_STR);
        $statement->bindValue(':id', $_POST['id'], PDO::PARAM_INT);

        $statement->execute();

        echo "De persoonsgegevens zijn gewijzigd";

        header("Refresh:2.5; url=read.php");
        exit();
    }

    /**
     * Maak een select-query voor het formulier zodat de gegevens aangepast kunnen worden
     */
    $sql = "SELECT Id
                  ,Voornaam
                  ,Tussenvoegsel
                  ,Achternaam
                  ,Wachtwoord
            FROM  Persoon
            WHERE Id = :id";

    /**
     * Maak de query geschikt voor het PDO object
     */
    $statement = $pdo->prepare($sql);

    /**
     * Verbind de $_GET['id'] waarde aan de placholder :id
     */
    $statement->bindValue(':id', $_GET['id'], PDO::PARAM_INT);

    /**
     * Voer de query uit
     */
    $statement->execute();

    /**
     * We halen het resultaat van de query op en stoppen dit in de variabele
     * $result
     */
    $result = $statement->fetch(PDO::FETCH_OBJ);

    /**
     * We tonen het resultaat
     */
    // var_dump($result);

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
    <h3>Persoonsgegevens wijzigen</h3>

    <form method="post" action="update.php">
        <label for="firstname">Voornaam: </label>
        <input type="text" name="firstname" id="firstname" value="<?= $result->Voornaam; ?>"><br><br>

        <label for="infix">Tussenvoegsel: </label>
        <input type="text" name="infix" id="infix" value="<?= $result->Tussenvoegsel; ?>"><br><br>

        <label for="lastname">Achternaam: </label>
        <input type="text" name="lastname" id="lastname" value="<?= $result->Achternaam; ?>"><br><br>

        <label for="password">Wachtwoord: </label>
        <input type="password" name="password" id="password" value="<?= $result->Wachtwoord; ?>"><br><br>

        <input type="hidden" name="id" value="<?= $result->Id; ?>">

        <input type="submit" value="Wijzig" name="submit">
    </form>
</body>
</html>