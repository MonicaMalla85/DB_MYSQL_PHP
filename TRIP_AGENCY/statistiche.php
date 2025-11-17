<?php
include 'header.php';
include 'db.php';

//Recupera anni disponibili dalle prenotazioni per filtro
$anni_result = $conn->query("SELECT DISTINCT YEAR(dataprenotazione) as anno FROM prenotazioni ORDER BY anno ASC");
$anni = [];
while($a = $anni_result->fetch_assoc()){
    $anni[] = $a['anno'];
}

//Recupera destinazioni disponibili per filtro
$dest_result = $conn->query("SELECT id, citta, paese FROM destinazioni ORDER BY citta ASC");
$destinazioni = [];
while($d = $dest_result->fetch_assoc()){
    $destinazioni[] = $d;
}

//Valori selezionati dal form
$anno_sel = $_GET['anno'] ?? '';
$dest_sel = $_GET['destinazione'] ?? '';

//Filtro per query
$filtroAnno = $anno_sel ? " AND YEAR(p.dataprenotazione) = ".intval($anno_sel) : "";
$filtroDest = $dest_sel ? " AND p.id_destinazione = ".intval($dest_sel) : "";

//QUERY PRENOTAZIONI PER MESE
$prenotazioni_mese = $conn->query("
    SELECT MONTH(p.dataprenotazione) as mese, COUNT(*) as totale
    FROM prenotazioni p
    WHERE 1=1 $filtroAnno $filtroDest
    GROUP BY mese
    ORDER BY mese ASC
");

//Inizializza array mesi
$mesi = range(1,12);
$totalePrenotazioni = array_fill(1,12,0);
while($row = $prenotazioni_mese->fetch_assoc()){
    $totalePrenotazioni[intval($row['mese'])] = intval($row['totale']);
}

//QUERY ENTRATE MENSILI
$entrate_mese = $conn->query("
    SELECT MONTH(p.dataprenotazione) as mese, SUM(p.numero_persone * d.prezzo) as totale
    FROM prenotazioni p
    JOIN destinazioni d ON p.id_destinazione = d.id
    WHERE 1=1 $filtroAnno $filtroDest
    GROUP BY mese
    ORDER BY mese ASC
");

//Inizializza array mesi entrate
$entrateMensili = array_fill(1,12,0);
while($row = $entrate_mese->fetch_assoc()){
    $entrateMensili[intval($row['mese'])] = floatval($row['totale']);
}

?>

<h2>Statistiche</h2>

<form action="" method="GET" class="row g-3 mb-4">

    <div class="col-md-3">
        <label for="">Anno</label>
        <select name="anno" class="form-select">
            <option value="">Tutti</option>
            <?php foreach($anni as $anno): ?>
                <option value="<?= $anno ?>" <?= $anno==$anno_sel?'selected':'' ?>><?= $anno ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-3">
        <label for="">Destinazione</label>
        <select name="destinazione" class="form-select">
            <option value="">Tutte</option>
            <?php foreach($destinazioni as $d): ?>
                <option value="<?= $d['id'] ?>" <?= $d['id']==$dest_sel?'selected':'' ?>>
                    <?= $d['citta'].", ".$d['paese'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-3 d-flex align-items-end">
        <button class="btn btn-primary">Aggiorna</button>
    </div>

    <div class="col-md-3 d-flex align-items-end justify-content-end">
        <a href="statistiche.php" class="btn btn-outline-success">Esporta dati in CSV</a>
    </div>

</form>

<div class="row">

    <div class="col-md-6 mb-4 mt-4">
        <div class="card p-3">
            <h5 class="text-center">Prenotazioni per mese</h5>
            <canvas id="lineaPrenotazioni"></canvas>
            <button class="btn btn-sm btn-outline-secondary mt-3">Scarica PNG</button>
        </div>
    </div>

    <div class="col-md-6 mb-4 mt-4">
        <div class="card p-3">
            <h5 class="text-center">Entrate Mensili (€)</h5>
            <canvas id="barEntrate"></canvas>
            <button class="btn btn-sm btn-outline-secondary mt-3">Scarica PNG</button>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const mesiLabels = ["Gen", "Feb", "Mar", "Apr", "Mag", "Giu", "Lug", "Ago", "Set", "Ott", "Nov", "Dic"];
const prenotazioniData = <?= json_encode(array_values($totalePrenotazioni)) ?>;
const entrateData = <?= json_encode(array_values($entrateMensili)) ?>;

//Grafico prenotazioni
const ctxPren = document.getElementById('lineaPrenotazioni');
new Chart(ctxPren, {
    type: 'line',
    data: {
        labels: mesiLabels,
        datasets: [{
            label: 'Numero Prenotazioni',
            data: prenotazioniData,
            borderColor: 'blue',
            backgroundColor: 'rgba(0,123,255,0.2)',
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        responsive:true,
        scales: { y: { beginAtZero:true } }
    }
});

//Grafico entrate
const ctxEntrate = document.getElementById('barEntrate');
new Chart(ctxEntrate, {
    type: 'bar',
    data: {
        labels: mesiLabels,
        datasets: [{
            label: 'Entrate Mensili (€)',
            data: entrateData,
            backgroundColor: 'green'
        }]
    },
    options: {
        responsive:true,
        scales: { y: { beginAtZero:true } }
    }
});
</script>

<?php include 'footer.php'; ?>
