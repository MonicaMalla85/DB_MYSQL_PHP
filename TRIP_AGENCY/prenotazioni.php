<?php
include 'header.php';
include 'db.php';

//LOGICA PER IMPAGINAZIONE
$perPagina = 10;
$page = isset($_GET['page']) ? max(1,intval($_GET['page'])) : 1;
$offset = ($page-1)*$perPagina;

//PRENDE CLIENTI E DESTINAZIONI PER I SELECT
$clienti = $conn->query("SELECT id, nome, cognome FROM clienti ORDER BY nome ASC");
$destinazioni = $conn->query("SELECT id, citta, paese FROM destinazioni ORDER BY citta ASC");

//LOGICA DI AGGIUNTA
if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['aggiungi'])){
    $assicurazione = isset($_POST['assicurazione']) ? 1 : 0;
    $stmt = $conn->prepare("INSERT INTO prenotazioni (id_cliente, id_destinazione, dataprenotazione, acconto, numero_persone, assicurazione) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "iisddi",
        $_POST['id_cliente'],
        $_POST['id_destinazione'],
        $_POST['dataprenotazione'],
        $_POST['acconto'],
        $_POST['numero_persone'],
        $assicurazione
    );
    $stmt->execute();
    echo "<div class='alert alert-success'>Prenotazione aggiunta correttamente!</div>";
}

//LOGICA DI MODIFICA
$prenotazione_modifica = null;
if(isset($_GET['modifica'])){
    $res = $conn->query("SELECT * FROM prenotazioni WHERE id=".intval($_GET['modifica']));
    $prenotazione_modifica = $res->fetch_assoc();
}

//SALVATAGGIO MODIFICA
if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['salva_modifica'])){
    $assicurazione = isset($_POST['assicurazione']) ? 1 : 0;
    $stmt = $conn->prepare("UPDATE prenotazioni SET id_cliente=?, id_destinazione=?, dataprenotazione=?, acconto=?, numero_persone=?, assicurazione=? WHERE id=?");
    $stmt->bind_param(
        "iisddii",
        $_POST['id_cliente'],
        $_POST['id_destinazione'],
        $_POST['dataprenotazione'],
        $_POST['acconto'],
        $_POST['numero_persone'],
        $assicurazione,
        $_POST['id']
    );
    $stmt->execute();
    echo "<div class='alert alert-info'>Prenotazione modificata correttamente!</div>";
}

//CANCELLAZIONE
if(isset($_GET['elimina'])){
    $id = intval($_GET['elimina']);
    $conn->query("DELETE FROM prenotazioni WHERE id=$id");
    echo "<div class='alert alert-info'>Prenotazione cancellata correttamente!</div>";
}

//LOGICA RENDER TABELLARE
$total = $conn->query("SELECT COUNT(*) as t FROM prenotazioni")->fetch_assoc()['t'];
$totalPages = ceil($total/$perPagina);

//Query per mostrare prenotazioni con JOIN per nomi leggibili
$result = $conn->query("
    SELECT p.*, c.nome AS cliente_nome, c.cognome AS cliente_cognome, d.citta AS destinazione_citta, d.paese AS destinazione_paese
    FROM prenotazioni p
    JOIN clienti c ON p.id_cliente = c.id
    JOIN destinazioni d ON p.id_destinazione = d.id
    ORDER BY p.id ASC
    LIMIT $perPagina OFFSET $offset
");
?>

<h2>Prenotazioni</h2>

<!--Form-->
<div class="card mb-4">
    <div class="card-body">
        <form action="" method="POST">
            <?php if($prenotazione_modifica): ?>
                <input type="hidden" name="id" value="<?= $prenotazione_modifica['id'] ?>">
            <?php endif; ?>

            <div class="row g-3">
                <div class="col-md-6">
                    <label style="font-weight:600;">Cliente :</label>
                    <select name="id_cliente" class="form-select" required>
                        <option value="">Seleziona Cliente</option>
                        <?php while($c = $clienti->fetch_assoc()): ?>
                            <option value="<?= $c['id'] ?>" <?= ($prenotazione_modifica && $prenotazione_modifica['id_cliente']==$c['id'])?'selected':'' ?>>
                                <?= $c['nome']." ".$c['cognome'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label style="font-weight:600;">Destinazione :</label>
                    <select name="id_destinazione" class="form-select" required>
                        <option value="">Seleziona Destinazione</option>
                        <?php while($d = $destinazioni->fetch_assoc()): ?>
                            <option value="<?= $d['id'] ?>" <?= ($prenotazione_modifica && $prenotazione_modifica['id_destinazione']==$d['id'])?'selected':'' ?>>
                                <?= $d['citta'].", ".$d['paese'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label style="font-weight:600;">Data Prenotazione :</label>
                    <input type="date" name="dataprenotazione" class="form-control"
                           value="<?= $prenotazione_modifica['dataprenotazione'] ?? '' ?>" required>
                </div>

                <div class="col-md-6">
                    <label style="font-weight:600;">Numero Persone :</label>
                    <input type="number" name="numero_persone" class="form-control"
                           value="<?= $prenotazione_modifica['numero_persone'] ?? '' ?>" required>
                </div>

                <div class="col-md-6">
                    <label style="font-weight:600;">Acconto :</label>
                    <input type="number" step="0.01" name="acconto" class="form-control"
                           value="<?= $prenotazione_modifica['acconto'] ?? '' ?>" required>
                </div>

                <div class="col-md-6 d-flex align-items-center">
                    <input type="checkbox" name="assicurazione" class="form-check-input me-2"
                        <?= ($prenotazione_modifica && $prenotazione_modifica['assicurazione'])?'checked':'' ?>>
                    <label style="font-weight:600;" class="form-check-label">Assicurazione</label>
                </div>

                <div class="col-12">
                    <button name="<?= $prenotazione_modifica ? 'salva_modifica' : 'aggiungi' ?>"
                            class="btn btn-<?= $prenotazione_modifica ? 'warning' : 'success' ?>"
                            type="submit">
                        <?= $prenotazione_modifica ? 'Salva Modifica' : 'Aggiungi Prenotazione' ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!--Tabella-->
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Destinazione</th>
            <th>Data Prenotazione</th>
            <th>Numero Persone</th>
            <th>Acconto</th>
            <th>Assicurazione</th>
            <th>Azioni</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['cliente_nome']." ".$row['cliente_cognome'] ?></td>
                <td><?= $row['destinazione_citta'].", ".$row['destinazione_paese'] ?></td>
                <td><?= $row['dataprenotazione'] ?></td>
                <td><?= $row['numero_persone'] ?></td>
                <td><?= $row['acconto'] ?></td>
                <td><?= $row['assicurazione'] ? 'Sì' : 'No' ?></td>
                <td>
                    <a class="btn btn-sm btn-warning" href="?modifica=<?= $row['id'] ?>">Modifica</a>
                    <a class="btn btn-sm btn-danger" href="?elimina=<?= $row['id'] ?>" onclick="return confirm('Sicuro di voler eliminare questa prenotazione?')">Elimina</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!--Paginazione-->
<nav>
    <ul class="pagination">
        <?php for($i=1;$i<=$totalPages;$i++): ?>
            <li class="page-item <?= $i==$page?'active':'' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>

<?php include 'footer.php'; ?>
