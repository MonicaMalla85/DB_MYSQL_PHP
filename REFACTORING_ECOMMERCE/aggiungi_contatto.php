<?php
require 'db.php';

//se il form è stato inviato tramite il metodo POST
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $nome = $_POST['nome'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    //query
    $sql = "INSERT INTO contatti( nome, telefono, email ) VALUES('$nome','$telefono','$email')";

    //eseguo la query
    mysqli_query($conn, $sql);

    //rendirizzamento utente alla index post inserimento
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Contatto</title>

    <!-- BOOTSTRAP 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS PERSONALIZZATO -->
    <link rel="stylesheet" href="style.css?v<?= time() ?>">
</head>
<body class="bg-light">

<div class="container my-5 p-4 bg-white rounded shadow">
    <h1 class="mb-4">Aggiungi contatto</h1>

    <form action="" method="POST" class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Nome</label>
            <input name="nome" type="text" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Telefono</label>
            <input name="telefono" type="text" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Email</label>
            <input name="email" type="email" class="form-control" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-success">Salva</button>
            <a href="index.php" class="btn btn-secondary">Torna alla lista</a>
        </div>
    </form>
</div>

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
