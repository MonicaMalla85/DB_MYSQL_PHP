<?php
require 'db.php';

// Controllo che l'id del contatto sia passato
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    // Aggiorno i dati nel database
    $sql = "UPDATE contatti SET nome='$nome', telefono='$telefono', email='$email' WHERE id=$id";
    mysqli_query($conn, $sql);

    // Redirect alla lista
    header("Location: index.php");
    exit;
}

// Prelevo i dati attuali del contatto
$result = mysqli_query($conn, "SELECT * FROM contatti WHERE id=$id");
$contatto = mysqli_fetch_assoc($result);

// Se non esiste il contatto
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
    <title>Modifica Contatto</title>
    <link rel="stylesheet" href="style.css?v<?= time() ?>">
</head>
<body>
    <div class="container">
        <h1>Modifica contatto</h1>

        <form action="" method="POST">
            Nome : <input name="nome" type="text" value="<?= htmlspecialchars($contatto['nome']) ?>" required>
            Telefono : <input name="telefono" type="text" value="<?= htmlspecialchars($contatto['telefono']) ?>" required>
            Email : <input name="email" type="text" value="<?= htmlspecialchars($contatto['email']) ?>" required>
            <button type="submit">Salva modifiche</button>
        </form>

        <a href="index.php" class="button">Torna alla lista</a>
    </div>
</body>
</html>
