<?php 
    include 'header.php'; 
    include 'db.php'; 

    //LOGICA PER IMPAGINAZIONE
    $perPagina = 10;  // numero elementi mostrati per pagina
    $page = isset($_GET['page']) ? max(1,intval($_GET['page'])) : 1;
    $offset = ($page - 1) * $perPagina;

    //LOGICA DI AGGIUNTA
    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['aggiungi'])){
        // MODIFICATO: Aggiunto posti_disponibili nel bind e nel prepare
        $stmt = $conn->prepare("INSERT INTO destinazioni (citta, paese, prezzo, data_partenza, data_ritorno, posti_disponibili) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "ssdssi", 
            $_POST['citta'], 
            $_POST['paese'], 
            $_POST['prezzo'], 
            $_POST['data_partenza'], 
            $_POST['data_ritorno'], 
            $_POST['posti_disponibili']
        );
        $stmt->execute();
        echo "<div class='alert alert-success'>Destinazione Aggiunta!</div>";
    }

    //LOGICA DI MODIFICA
    $destinazione_modifica = null;
    if(isset($_GET['modifica'])){
        $res = $conn->query("SELECT * FROM destinazioni WHERE id=" . intval($_GET['modifica']));
        $destinazione_modifica = $res->fetch_assoc();
    }

    //MODIFICA DEL DATO, SALVATAGGIO
    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['salva_modifica'])){
        // MODIFICATO: Aggiunto posti_disponibili al set + id nel bind
        $stmt = $conn->prepare("UPDATE destinazioni SET citta=?, paese=?, prezzo=?, data_partenza=?, data_ritorno=?, posti_disponibili=? WHERE id=?");
        $stmt->bind_param(
            "ssdssii", 
            $_POST['citta'], 
            $_POST['paese'], 
            $_POST['prezzo'], 
            $_POST['data_partenza'], 
            $_POST['data_ritorno'], 
            $_POST['posti_disponibili'],
            $_POST['id']
        );
        $stmt->execute();
        echo "<div class='alert alert-info'>Destinazione modificata correttamente</div>";
    }

    //CANCELLAZIONE DESTINAZIONE
    if(isset($_GET['elimina'])){
        $id = intval($_GET['elimina']);
        $conn->query("DELETE FROM destinazioni WHERE id=$id");
        echo "<div class='alert alert-info'>Destinazione Cancellata correttamente</div>";
    }

?>

<h2>Destinazioni</h2>

<!--Form-->
<div class="card mb-4">
    <div class="card-body">
        <form action="" method="POST">

            <?php if($destinazione_modifica): ?>
                <input type="hidden" name="id" value="<?= $destinazione_modifica['id'] ?>">
            <?php endif; ?>

            <div class="row g-3">

                <div class="col-md-6">
                    <label style="font-weight: 600;" for="">Città : </label>
                    <input type="text" name="citta" class="form-control" placeholder="es.: Milano" 
                        value="<?= $destinazione_modifica['citta'] ?? ''?>" required>
                </div>

                <div class="col-md-6">
                    <label style="font-weight: 600;" for="">Paese : </label>
                    <input type="text" name="paese" class="form-control" placeholder="es.: Italia" 
                        value="<?= $destinazione_modifica['paese'] ?? ''?>" required>
                </div>

                <div class="col-md-6">
                    <label style="font-weight: 600;" for="">Prezzo : </label>
                    <input type="number" step="0.01" name="prezzo" class="form-control" 
                        value="<?= $destinazione_modifica['prezzo'] ?? ''?>" required>
                </div>

                <div class="col-md-6">
                    <label style="font-weight: 600;" for="">Data Partenza : </label>
                    <input type="date" name="data_partenza" class="form-control" 
                        value="<?= $destinazione_modifica['data_partenza'] ?? ''?>" required>
                </div>

                <div class="col-md-6">
                    <label style="font-weight: 600;" for="">Data Ritorno : </label>
                    <input type="date" name="data_ritorno" class="form-control" 
                        value="<?= $destinazione_modifica['data_ritorno'] ?? ''?>" required>
                </div>

                <div class="col-md-6">
                    <label style="font-weight: 600;" for="">Posti Disponibili : </label>
                    <input type="number" name="posti_disponibili" class="form-control" 
                        value="<?= $destinazione_modifica['posti_disponibili'] ?? ''?>" required>
                </div>

                <div class="col-12">
                    <button 
                        name="<?= $destinazione_modifica ? 'salva_modifica' : 'aggiungi' ?>" 
                        class="btn btn-<?= $destinazione_modifica ? 'warning' : 'success' ?>" 
                        type="submit">
                        <?= $destinazione_modifica ? 'Salva' : 'Aggiungi' ?>
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<!--LOGICA RENDER -->
<?php
    // conteggio totale destinazioni
    $total = $conn->query("SELECT COUNT(*) as t FROM destinazioni")->fetch_assoc()['t'];
    $totalPages = ceil($total / $perPagina);

    // query per ordinare i dati in modo decrescente e impaginati
    $result = $conn->query("SELECT * FROM destinazioni ORDER BY id ASC LIMIT $perPagina OFFSET $offset");
?>

<!--Tabella-->
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Città</th>
            <th>Paese</th>
            <th>Prezzo</th>
            <th>Data Partenza</th>
            <th>Data Ritorno</th>
            <th>Posti</th>
            <th>Azioni</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['citta'] ?></td>
                <td><?= $row['paese'] ?></td>
                <td><?= $row['prezzo'] ?></td>
                <td><?= $row['data_partenza'] ?></td>
                <td><?= $row['data_ritorno'] ?></td>
                <td><?= $row['posti_disponibili'] ?></td>
                <td>
                    <a class="btn btn-sm btn-warning" href="?modifica=<?= $row['id'] ?>">Modifica</a>
                    <a class="btn btn-sm btn-danger" href="?elimina=<?= $row['id'] ?>" onclick="return confirm('Sicuro?')">Elimina</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!--Paginazione-->
<nav>
    <ul class="pagination">
        <?php for($i=1; $i<=$totalPages; $i++): ?>
            <li class="page-item <?= $i==$page ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>

<?php include 'footer.php'; ?>
