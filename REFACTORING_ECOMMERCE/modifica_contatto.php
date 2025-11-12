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

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css?v<?= time() ?>">
</head>
<body class="bg-light">

<div class="container my-5 p-4 bg-white rounded shadow">
    <h1 class="mb-4">Modifica contatto</h1>

    <form action="" method="POST" class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Nome</label>
            <input name="nome" type="text" class="form-control" value="<?= htmlspecialchars($contatto['nome']) ?>" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Telefono</label>
            <input name="telefono" type="text" class="form-control" value="<?= htmlspecialchars($contatto['telefono']) ?>" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Email</label>
            <input name="email" type="email" class="form-control" value="<?= htmlspecialchars($contatto['email']) ?>" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-success">Salva modifiche</button>
            <a href="index.php" class="btn btn-secondary">Torna alla lista</a>
        </div>
    </form>
</div>

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
