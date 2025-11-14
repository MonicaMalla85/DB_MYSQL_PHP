<?php include 'header.php'; ?>
<?php include 'db.php'; ?>

<h2>Clienti</h2>

<div class="card mb-4">
    <div class="card-body">

        <form action="" method="POST">

            <!-- 
                MODIFICA: ho sostituito una singola <div class="row"> piena di label e input
                con un layout ordinato, usando col-md-6 per avere 2 campi per ogni riga.
            -->
            <div class="row g-3">

                <!-- MODIFICA: ogni input è ora in una colonna propria -->
                <div class="col-md-6">
                    <label class="form-label">Nome</label>
                    <input type="text" name="nome" class="form-control" placeholder="Inserisci il nome..." required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Cognome</label>
                    <input type="text" name="cognome" class="form-control" placeholder="Inserisci il cognome..." required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="text" name="email" class="form-control" placeholder="Inserisci l'email..." required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Telefono</label>
                    <input type="text" name="telefono" class="form-control" placeholder="Inserisci il telefono..." required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nazione</label>
                    <input type="text" name="nazione" class="form-control" placeholder="Inserisci la nazione..." required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Codice Fiscale</label>
                    <input type="text" name="codice_fiscale" class="form-control" placeholder="Inserisci il codice fiscale..." required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Documento</label>
                    <input type="text" name="documento" class="form-control" placeholder="Inserisci il documento..." required>
                </div>

                <!-- 
                    MODIFICA: il bottone ora è in una riga separata 
                    e allineato a destra con text-end
                -->
                <div class="col-12 text-end">
                    <button class="btn btn-success" type="submit">Salva</button>
                </div>

            </div>
        </form>

    </div>
</div>


<!-- TABELLA: non modificata, solo mantenuta così com'era -->
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Cognome</th>
            <th>Email</th>
            <th>Telefono</th>
            <th>Nazione</th>
            <th>Cod.Fiscale</th>
            <th>Documento</th>
            <th>Azioni</th>
        </tr>
    </thead>

    <tbody>

    </tbody>
</table>

<?php include 'footer.php'; ?>
