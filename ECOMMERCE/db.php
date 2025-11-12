<?php

    //CONNESSIONE AL DB MYSQL usando MYSQLI

    //paramentri di connessione al database

    $host = "localhost";  //host
    $user = "root";       //utente standard di default-> root
    $password = "";       //non abbiamo inserito nessuna password (la chiede durante la installazione di XAMPP)
    $database = "ecommerce"; //nome db su phpmyadmin

    //creo la connessione
    $conn = mysqli_connect($host, $user, $password, $database);

    //verifico la connessione
    if(!$conn){
        //se la connessione fallisce stampa un messaggio di errore e termina lo script
        die("Connsessione fallita: " . mysqli_connect());
    }

?>