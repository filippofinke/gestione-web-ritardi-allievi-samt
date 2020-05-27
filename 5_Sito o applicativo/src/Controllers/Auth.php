<?php

namespace FilippoFinke\Controllers;

use FilippoFinke\Libs\Session;
use FilippoFinke\Request;
use FilippoFinke\Response;
use FilippoFinke\Models\Users;
use FilippoFinke\Models\Tokens;
use FilippoFinke\Libs\Validator;

/**
 * Auth.php
 * Controller che si occupa di gestire tutti i percorsi relativi all'autenticazione.
 *
 * @author Filippo Finke
 */
class Auth
{
    /**
     * Metodo che si occupa di caricare la pagina di accesso.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function login(Request $req, Response $res)
    {
        // Ricavo il token di recupero password / attivazione se presente.
        $token = $req->getAttribute("token");
        // Carico la pagina di login passando anche il token.
        return $res->render(
            __DIR__ . '/../Views/Auth/login.php',
            array("token" => $token)
        );
    }

    /**
     * Metodo che si occupa di caricare la pagina di recupero password.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function forgotPassword(Request $req, Response $res)
    {
        // Carico la pagina di recupero password.
        return $res->render(__DIR__ . '/../Views/Auth/forgot-password.php');
    }

    /**
     * Metodo utilizzato per verificare le credenziali dell'utente.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function doLogin(Request $req, Response $res)
    {
        // Ricavo l'email dalla richiesta.
        $email = $req->getParam("email");
        // Ricavo la password dalla richiesta.
        $password = $req->getParam("password");

        // Controllo che email e password siano di un formato valido.
        if ($email && Validator::isValidEmail($email) && $password && Validator::isValidPassword($password)) {
            // Ricavo un utente con l'email specificata al login.
            $user = Users::getByEmail($email);
            // Controllo l'esistenza dell'utente e se la password inserita è corretta.
            if ($user && password_verify($password, $user["password"])) {
                // Rimuovo la password dall'array che verrà salvato in sessione per sicurezza.
                unset($user["password"]);
                // Aggiorno i dati della sessione.
                Session::authenticate($user);
                // Ritorno una richiesta con stato 200 - Success.
                return $res->withStatus(200);
            }
        }
        // Ritorno una richiesta con stato 403 - Forbidden.
        return $res->withStatus(403);
    }

    /**
     * Metodo utilizzato per eseguire la disconnessione.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function doLogout(Request $req, Response $res)
    {
        // Cancello tutti i dati della sessione.
        Session::logout();
        // Eseguo un redirect alla pagina di login.
        return $res->redirect(BASE . "login");
    }

    /**
     * Metodo utilizzato per eseguire il recupero password.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function doForgotPassword(Request $req, Response $res)
    {
        // Ricavo l'email dalla richiesta.
        $email = $req->getParam("email");

        // Controllo che l'email sia valida.
        if ($email && Validator::isValidEmail($email)) {
            // Provo ad inviare un token di recupero password.
            if (Tokens::sendResetPasswordToken($email)) {
                // Ritorno una richiesta con stato 200 - Success.
                return $res->withStatus(200);
            } else {
                // Ritorno una richiesta con stato 500 - Internal Server Error.
                return $res->withStatus(500);
            }
        }
        // Ritorno una richiesta con stato 400 - Bad Request.
        return $res->withStatus(400);
    }

    /**
     * Metodo utilizzato per cambiare la password.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function doChangePassword(Request $req, Response $res)
    {
        // Ricavo il token di recupero password dalla richiesta.
        $token = $req->getParam("token");
        // Ricavo la password dalla richiesta.
        $password = $req->getParam("password");
        // Controllo la presenza dei parametri ed eseguo il cambio password.
        if ($token && $password && Users::changePassword($token, $password)) {
            // Ritorno una richiesta con stato 200 - Success.
            return $res->withStatus(200);
        }
        // Ritorno una richiesta con stato 400 - Bad Request.
        return $res->withStatus(400);
    }
}
