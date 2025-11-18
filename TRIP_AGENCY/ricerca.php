<?php
include 'header.php';
include 'db.php';

// Inizializza variabili di filtro
$citta = $_GET['citta'] ?? '';
$paese = $_GET['paese'] ?? '';
$prezzo_min = $_GET['prezzo_min'] ?? '';
$prezzo_max = $_GET['prezzo_max'] ?? '';
$data_partenza = $_GET['data_partenza'] ?? '';
$data_ritorno = $_GET['data_ritorno'] ?? '';

// Costruisci la query dinamica
$where = [];
$params = [];
$types = '';

if($citta) {
    $where[] = "citta LIKE ?";
    $params[] = "%$citta%";
    $types .= 's';
}
if($paese) {
    $where[] = "paese LIKE ?";
    $params[] = "%$paese%";
    $types .= 's';
}
if($prezzo_min) {
    $where[] = "prezzo >= ?";
    $params[] = $prezzo_min;
    $types .= 'i';
}
if($prezzo_max) {
    $where[] = "prezzo <= ?";
    $params[] = $prezzo_max;
    $types .= 'i';
}
if($data_partenza) {
    $where[] = "data_partenza >= ?";
    $params[] = date('Y-m-d', strtotime($data_partenza));
    $types .= 's';
}
if($data_ritorno) {
    $where[] = "data_ritorno <= ?";
    $params[] = date('Y-m-d', strtotime($data_ritorno));
    $types .= 's';
}

$query = "SELECT * FROM destinazioni";
if($where) {
    $query .= " WHERE " . implode(' AND ', $where);
}
$query .= " ORDER BY data_partenza ASC";

$stmt = $conn->prepare($query);
if($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<h2>Ricerca Destinazioni</h2>

<!--Form di ricerca-->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="">
            <div class="row g-3">

                <div class="col-md-3">
                    <label style="font-weight:600;">Città</label>
                    <input type="text" name="citta" class="form-control" value="<?= htmlspecialchars($citta) ?>" placeholder="es. Milano">
                </div>

                <div class="col-md-3">
                    <label style="font-weight:600;">Paese</label>
                    <input type="text" name="paese" class="form-control" value="<?= htmlspecialchars($paese) ?>" placeholder="es. Italia">
                </div>

                <div class="col-md-2">
                    <label style="font-weight:600;">Prezzo Min</label>
                    <input type="number" name="prezzo_min" class="form-control" value="<?= htmlspecialchars($prezzo_min) ?>" min="1">
                </div>

                <div class="col-md-2">
                    <label style="font-weight:600;">Prezzo Max</label>
                    <input type="number" name="prezzo_max" class="form-control" value="<?= htmlspecialchars($prezzo_max) ?>" min="1">
                </div>

                <div class="col-md-3">
                    <label style="font-weight:600;">Data Partenza</label>
                    <input type="date" name="data_partenza" class="form-control" value="<?= htmlspecialchars($data_partenza) ?>">
                </div>

                <div class="col-md-3">
                    <label style="font-weight:600;">Data Ritorno</label>
                    <input type="date" name="data_ritorno" class="form-control" value="<?= htmlspecialchars($data_ritorno) ?>">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Cerca</button>
                </div>

            </div>
        </form>
    </div>
</div>

<!--Tabella risultati-->
<?php if($result->num_rows > 0): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Città</th>
                <th>Paese</th>
                <th>Prezzo</th>
                <th>Data Partenza</th>
                <th>Data Ritorno</th>
                <th>Posti Disponibili</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['citta']) ?></td>
                    <td><?= htmlspecialchars($row['paese']) ?></td>
                    <td><?= $row['prezzo'] ?></td>
                    <td><?= date('d/m/Y', strtotime($row['data_partenza'])) ?></td>
                    <td><?= date('d/m/Y', strtotime($row['data_ritorno'])) ?></td>
                    <td><?= $row['posti_disponibili'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-info">Nessuna destinazione trovata con i criteri selezionati.</div>
<?php endif; ?>

<?php include 'footer.php'; ?>
