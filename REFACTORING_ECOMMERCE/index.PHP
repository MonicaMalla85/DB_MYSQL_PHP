<?php
    //importo il file db
    require 'db.php';

    //salvo in una variabile $result, i risultati della query
    $result = mysqli_query($conn, "SELECT * FROM contatti"); // query per prendermi tutta la tabella contatti
?>


<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce</title>

    <!-- INCLUSIONE BOOTSTRAP 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- LINK CSS PERSONALIZZATO -->
    <link rel="stylesheet" href="style.css?v<?= time() ?>">
</head>
<body class="bg-light">

    <div class="container my-5 p-4 bg-white rounded shadow">
        <h1 class="mb-4">Rubrica contatti</h1>

        <a href="aggiungi_contatto.php" class="btn btn-primary mb-3">Aggiungi contatto</a>

        <table class="table table-striped table-hover">
            <thead class="table-primary">
                <tr>
                    <th>Nome</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!--Ciclo WHILE FINTANTO CHE HO RESULT, MOSTRAMELI IN ROW DEDICATE--->
                <?php  while($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td>
                            <!--HTMLSPECIALCHARS aggiunge alla pagina html parti di codice-->
                            <?= htmlspecialchars($row['nome']) ?> <!--mostra nome-->
                        </td>
                        <td>
                            <?= htmlspecialchars($row['telefono']) ?> <!--mostra telefono-->
                        </td>
                        <td>
                            <?= htmlspecialchars($row['email']) ?> <!--mostra email-->
                        </td>

                        <td>
                            <!-- Modifica: aggiunto passaggio dell'id del contatto tramite GET -->
                            <a href="modifica_contatto.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">🖊️</a>

                            <!-- Elimina: aggiunto passaggio dell'id del contatto tramite GET -->
                            <a href="elimina_contatto.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger">🗑️</a>

                            <!-- Ordini: aggiunto passaggio dell'id del contatto tramite GET -->
                            <a href="ordini.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info">📦</a>
                        </td>                          
                    </tr>
                <?php endwhile; ?>    
            </tbody>
        </table>
    </div>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
