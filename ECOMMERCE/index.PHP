<?php
    //importo il file db
    require 'db.php';

    //salvo in una variabile $result, i risultati della query
    $result = mysqli_query($conn, "SELECT * FROM contatti"); //query per prendermi tutta la tabella "contatti"
?>





<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">

        <h1>Rubrica contatti</h1>
        <a href="aggiungi_contatto.php" class="button">Aggiungi contatto</a>


        <table>

            <thead>
                <tr>
                    <th>
                        Nome:
                    </th>
                    <th>
                        Telefono:
                    </th>
                    <th>
                        Email:
                    </th>
                </tr>
            </thead>




            <tbody>
                <!---Ciclo WHILE FINTANTO CHE HO RESULT, MOSTRAMELI IN ROW DEDICATE--->
                    <?php  while($row = mysqli_fetch_assoc($result)) :   ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($row['nome']) ?>
                            </td>
                            <td> 
                                <?= htmlspecialchars($row['telefono']) ?>
                            </td>   
                            <td>   
                                <?= htmlspecialchars($row['email']) ?>
                            </td> 
                            <td class="action">

                                <a href="modifica_contatto.php">Edit</a>
                                <a href="elimina_contatto.php">Delete</a>
                                <a href="ordini.php">Ordini</a>

                            </td>
                        </tr>
                    
                    <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>
</html>