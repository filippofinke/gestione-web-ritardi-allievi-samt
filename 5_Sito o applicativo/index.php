<?php

use FilippoFinke\Middlewares\AuthRequired;
use FilippoFinke\Router;
use FilippoFinke\Response;
use FilippoFinke\Request;
use FilippoFinke\RouteGroup;
use FilippoFinke\Utils\Database;
use FilippoFinke\Libs\Mail;
use FilippoFinke\Libs\Session;
use FilippoFinke\Middlewares\AdminRequired;
use FilippoFinke\Middlewares\CreateRequired;
use FilippoFinke\Middlewares\InsertRequired;
use FilippoFinke\Middlewares\SelectRequired;
use FilippoFinke\Models\Settings;
use FilippoFinke\Models\Users;

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
    // Creo una risposta.
    $response = new Response();
    // Creo un array di variabili da passare alla pagina di errore.
    $info = array(
        "title" => "Impossibile stabilire la connessione con il database!",
        "message" => "Errore: " . $e->getMessage()
    );
    // Carico la pagina di errore.
    $response->render(__DIR__ . "/src/Views/Error/error.php", $info);
    // Termino l'esecuzione.
    exit;
}

// Imposto l'indirizzo email dal quale inviare la posta elettronica.
Mail::setFromEmail(Settings::getValue("from_email"));

// Creo un nuovo oggetto router che si occuperà di smistare le richieste.
$router = new Router();

// Imposto una funzione di default da chiamare in caso la pagina richiesta non esista.
$router->setNotFound(function (Request $req, Response $res) {
    // Eseguo un redirect alla pagina principale dell'applicativo.
    return $res->redirect(BASE);
});

// Percorso pagina di cambio password.
$router->get("/login/{token}", "FilippoFinke\Controllers\Auth::login");
// Percorso pagina di accesso.
$router->get("/login", "FilippoFinke\Controllers\Auth::login");
// Percorso pagina di recupero password.
$router->get("/forgot-password", "FilippoFinke\Controllers\Auth::forgotPassword");

// Percorso per eseguire il login.
$router->post("/login", "FilippoFinke\Controllers\Auth::doLogin");
// Percorso per eseguire la disconnessione.
$router->get("/logout", "FilippoFinke\Controllers\Auth::doLogout");
// Percorso per richiedere una email di recupero password.
$router->post("/forgot-password", "FilippoFinke\Controllers\Auth::doForgotPassword");
// Percorso per cambiare la password.
$router->post("/change-password", "FilippoFinke\Controllers\Auth::doChangePassword");

// Gruppo di percorsi dove è richiesto solamente l'accesso.
$homeRoutes = new RouteGroup();
$homeRoutes->add(
    // Percorso pagina ritardi.
    $router->get("/", "FilippoFinke\Controllers\Home::delays"),
    // Percorso pagina ritardi con un anno specifico.
    $router->get("/delays/{year}", "FilippoFinke\Controllers\Home::delays"),
    // Percorso pdf pagina recuperi.
    $router->get("/recoveries/pdf", "FilippoFinke\Controllers\Home::recoveriesPdf")->before(new CreateRequired()),
    // Percorso pagina recuperi.
    $router->get("/recoveries", "FilippoFinke\Controllers\Home::recoveries"),
    // Percorso creazione studente.
    $router->post("/student", "FilippoFinke\Controllers\Student::insert")->before(new InsertRequired()),
    // Percorso per creare un pdf dei ritardi.
    $router->get("/student/{id}/pdf", "FilippoFinke\Controllers\Student::pdf")->before(new CreateRequired()),
    // Percorso per ricavare i ritardi da recuperare di uno studente.
    $router->get("/student/{id}/{type}", "FilippoFinke\Controllers\Student::delays")->before(new SelectRequired()),
    // Percorso per ricavare i ritardi di uno studente.
    $router->get("/student/{id}", "FilippoFinke\Controllers\Student::delays")->before(new SelectRequired()),
    // Percorso di rimozione ritardo.
    $router->delete("/delay/{id}", "FilippoFinke\Controllers\Delay::delete")->before(new InsertRequired()),
    // Percorso di aggiornamento ritardo.
    $router->post("/delay/{id}", "FilippoFinke\Controllers\Delay::update")->before(new InsertRequired()),
    // Percorso di aggiunta ritardo.
    $router->post("/delay", "FilippoFinke\Controllers\Delay::insert")->before(new InsertRequired())
)
// Controllo autenticazione.
->before(new AuthRequired());

// Gruppo di percorsi dove è richiesto avere un permesso di amministratore.
$adminRoutes = new RouteGroup();
$adminRoutes->add(
    // Percorso pagina di gestione utenti.
    $router->get("/users", "FilippoFinke\Controllers\Home::users"),
    // Percorso pagina di gestione impostazioni.
    $router->get("/settings", "FilippoFinke\Controllers\Home::settings"),
    // Percorso creazione utenti.
    $router->post("/user", "FilippoFinke\Controllers\User::insert"),
    // Percorso aggiornamento utenti.
    $router->post("/user/{email}", "FilippoFinke\Controllers\User::update"),
    // Percorso rimozione utenti.
    $router->delete("/user/{email}", "FilippoFinke\Controllers\User::delete"),
    // Percorso aggiornamento impostazioni.
    $router->post("/setting/{setting}", "FilippoFinke\Controllers\Setting::update"),
    // Percorso creazione anno.
    $router->post("/year", "FilippoFinke\Controllers\Year::insert"),
    // Percorso rimozione anni.
    $router->delete("/year/{id}", "FilippoFinke\Controllers\Year::delete"),
    // Percorso creazione sezione.
    $router->post("/section", "FilippoFinke\Controllers\Section::insert"),
    // Percorso rimozione sezione.
    $router->delete("/section/{name}", "FilippoFinke\Controllers\Section::delete")
)
// Controllo permesso di amministratore.
->before(new AdminRequired());

// Rimuovo dall'url la base.
$_SERVER["REQUEST_URI"] = str_replace(BASE, "/", $_SERVER["REQUEST_URI"]);

// Controllo se l'utente è autenticato.
if (Session::isAuthenticated()) {
    // Ricavo le informazioni dell'utente.
    $user = Users::getByEmail($_SESSION["email"]);
    // Controllo che l'utente esista.
    if ($user) {
        // Rimuovo il campo password per sicurezza.
        unset($user["password"]);
        // Aggiorno i dati della sessione.
        Session::authenticate($user);
    } else {
        // Eseguo il logout dato che l'utente non esiste.
        Session::logout();
    }
}

// Avvio il routing della richiesta.
$router->start();
