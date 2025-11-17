<?php include 'header.php'; ?>
<?php include 'db.php'; ?>

<h2>Destinazioni</h2>

    <!--Form-->
    <div class="card mb-4">

        <div class="card-body">

            <form action="" method="POST">

                <div class="row g-3">
                    
                    <div class="col-md-6">
                        <label style="font-weight: 600;" for="">Città : </label>
                        <input type="text" name="citta" class="form-control" placeholder="es.: Milano" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label style="font-weight: 600;" for="">Paese : </label>
                        <input type="text" name="paese" class="form-control" placeholder="es.: Italia" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label style="font-weight: 600;" for="">Prezzo : </label>
                        <input type="number" name="prezzo" class="form-control" placeholder="" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label style="font-weight: 600;" for="">Data Partenza : </label>
                        <input type="date" name="data_partenza" class="form-control" placeholder="" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label style="font-weight: 600;" for="">Data Ritorno : </label>
                        <input type="date" name="data_ritorno" class="form-control" placeholder="" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label style="font-weight: 600;" for="">Posti Disponibili : </label>
                        <input type="number" name="posti_disponibili" class="form-control" placeholder="" required>
                    </div>
                    
                    
                    <div class="col-12">
                        <button class="btn btn-success" type="submit">Salva</button>
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


        

        </tbody>

    </table>


<?php include 'footer.php'; ?>