<?php
require 'db.php';

// Controllo che l'id sia passato
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Se l'utente conferma l'eliminazione
if (isset($_POST['conferma'])) {
    // Eseguo la query di eliminazione
    mysqli_query($conn, "DELETE FROM contatti WHERE id=$id");

    // Redirect alla lista
    header("Location: index.php");
    exit;
}

// Prelevo i dati del contatto da mostrare nella conferma
$result = mysqli_query($conn, "SELECT * FROM contatti WHERE id=$id");
$contatto = mysqli_fetch_assoc($result);

// Se il contatto non esiste
if (!$contatto) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elimina Contatto</title>
    <link rel="stylesheet" href="style.css?v<?= time() ?>">
</head>
<body>
    <div class="container">
        <h1>Elimina contatto</h1>

        <p>Sei sicuro di voler eliminare il contatto <strong><?= htmlspecialchars($contatto['nome']) ?></strong>?</p>

        <form method="POST">
            <button type="submit" name="conferma">Sì, elimina</button>
        </form>

        <a href="index.php" class="button">Annulla</a>
    </div>
</body>
</html>
