<?php

use FilippoFinke\Router;
use FilippoFinke\Response;
use FilippoFinke\Request;
use FilippoFinke\RouteGroup;
use FilippoFinke\Utils\Database;
use FilippoFinke\Middlewares\AdminRequired;
use FilippoFinke\Middlewares\AuthRequired;

// Includo le librerie attraverso l'autoload generato da composer.
require __DIR__ . '/vendor/autoload.php';

// Avvio della sessione per determinare lo stato dell'utente corrente.
session_start();

// Controllo per file statici, solamente se si usa il web server di PHP.
if (php_sapi_name() == 'cli-server') {
    $path = $_SERVER["REQUEST_URI"];
    if (strpos($path, '/assets/') !== false) {
        return false;
    }
}

// Controllo l'esistenza del file di configurazione.
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

// Creao un nuovo oggetto router che si occuperà di smistare le richieste.
$router = new Router();

// Imposto una funzione di default da chiamare in caso la pagina richiesta non esista.
$router->setNotFound(function (Request $req, Response $res) {
    return $res->redirect("/");
});

// Percorso pagina di accesso.
$router->get("/login", "FilippoFinke\Controllers\Auth::login");
// Percorso pagina di recupero password.
$router->get("/forgot-password", "FilippoFinke\Controllers\Auth::forgotPassword");

// Percorso per eseguire il login.
$router->post("/login", "FilippoFinke\Controllers\Auth::doLogin");
// Percorso per eseguire la disconnessione.
$router->get("/logout", "FilippoFinke\Controllers\Auth::doLogout");

// Gruppo di percorsi dove è richiesto solamente l'accesso.
$homeRoutes = new RouteGroup();
$homeRoutes->add(
    // Percorso pagina principale.
    $router->get("/", function($req, $res) {
        return $res->withHtml("<a href='/logout'>Esci</a>");
    })
)
// Controllo autenticazione.
->before(new AuthRequired());

// Avvio il routing della richiesta.
$router->start();
