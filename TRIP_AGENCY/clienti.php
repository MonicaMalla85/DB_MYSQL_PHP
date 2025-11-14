<?php include 'header.php'; ?>
<?php include 'db.php'; ?>

<h2>Clienti</h2>

    <div class="card mb-4">

        <div class="card-body">

            <form action="" method="POST">

                <div class="row g-2">
                    <label for="">Nome : </label>
                    <div class="col"><input type="text" name="nome" class="form-control" placeholder="Inserisci il nome del cliente.." required></div>
                    <label for="">Cognome : </label>
                    <div class="col"><input type="text" name="cognome" class="form-control" placeholder="Inserisci il cognome del cliente.." required></div>
                    <label for="">Email : </label>
                    <div class="col"><input type="text" name="email" class="form-control" placeholder="Inserisci l email del cliente.." required></div>
                    <label for="">Telefono : </label>
                    <div class="col"><input type="text" name="telefono" class="form-control" placeholder="Inserisci il telefono del cliente.." required></div>
                    <label for="">Nazione : </label>
                    <div class="col"><input type="text" name="nazione" class="form-control" placeholder="Inserisci la nazione del cliente.." required></div>
                    <label for="">Cod. Fiscale : </label>
                    <div class="col"><input type="text" name="codice_fiscale" class="form-control" placeholder="Inserisci il cod. fiscale del cliente.." required></div>
                    <label for="">Documento : </label>
                    <div class="col"><input type="text" name="documento" class="form-control" placeholder="Inserisci il codice del documento del cliente.." required></div>

                    <div class="col">
                        <button class="btn btn-success" type="submit">Salva</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



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