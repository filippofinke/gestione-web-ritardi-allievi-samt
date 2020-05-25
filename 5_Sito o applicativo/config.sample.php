<?php

/**
 * Config.php
 * File nel quale risiede la configurazione del progetto.
 *
 * @author Filippo Finke
 */

/**
 * Configurazione messaggi di errore.
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Cartella di base dell'applicativo.
define("BASE", "/");

/**
 * Configurazioni riguardanti la banca dati.
 */
// Indirizzo di connessione del database.
define("DB_HOST", "127.0.0.1");
// Il nome del database.
define("DB_NAME", "ritardi");
// L'username dell'utente da utilizzare per collegarsi al database.
define("DB_USERNAME", "USERNAME");
// La password da utilizzare per il collegamento al database.
define("DB_PASSWORD", "PASSWORD");
