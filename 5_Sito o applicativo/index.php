<?php
use FilippoFinke\Router;
use FilippoFinke\Response;
use FilippoFinke\Request;
use FilippoFinke\Utils\Database;

require __DIR__ . '/vendor/autoload.php';

session_start();

if (php_sapi_name() == 'cli-server') {
    $path = $_SERVER["REQUEST_URI"];
    if (strpos($path, '/assets/') !== false) {
        return false;
    }
}

// Controllo del file di configurazione.
if (!file_exists("config.php")) {
    $response = new Response();
    $info = array(
        "title" => "File di configurazione mancante!",
        "message" => "Impossibile caricare il file di configurazione (config.php)!<br><br>Se stai installando l'applicativo puoi trovare un file di configurazione di esempio chiamato config.sample.php che puoi rinominare config.php"
    );
    $response->render(__DIR__ . "/src/Views/Error/error.php", $info);
    exit;
}

// Includo del file di configurazione dell'applicativo.
require __DIR__ . '/config.php';

// Imposto indirizzo del server MySQL.
Database::setHost(DB_HOST);
// Imposto del database da utilizzare.
Database::setDatabase(DB_NAME);
// Imposto del nome utente per accedere al database.
Database::setUsername(DB_USERNAME);
// Imposto della password per accedere al database.
Database::setPassword(DB_PASSWORD);
// Controllo connessione alla banca dati.
try {
    Database::getConnection();
} catch (PDOException $e) {
    $response = new Response();
    $info = array(
        "title" => "Impossibile stabilire la connessione con il database!",
        "message" => "Errore: " . $e->getMessage()
    );
    $response->render(__DIR__ . "/src/Views/Error/error.php", $info);
    exit;
}


$router = new Router();

$router->setNotFound(function (Request $req, Response $res) {
    return $res->redirect("/");
});

$router->get("/", "FilippoFinke\Controllers\Test::index");

$router->start();
