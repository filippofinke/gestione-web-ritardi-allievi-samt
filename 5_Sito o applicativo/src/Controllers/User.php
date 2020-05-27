<?php

namespace FilippoFinke\Controllers;

use FilippoFinke\Libs\Validator;
use FilippoFinke\Models\Users;
use FilippoFinke\Request;
use FilippoFinke\Response;

/**
 * User.php
 * Controller che si occupa di gestire tutti i percorsi relativi alla modifica dei dati degli utenti.
 *
 * @author Filippo Finke
 */
class User
{
    /**
     * Metodo utilizzato per creare un utente.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function insert(Request $req, Response $res)
    {
        // Ricavo il nome.
        $name = trim($req->getParam('name'));
        // Ricavo il cognome.
        $lastname = trim($req->getParam('lastname'));
        // Ricavo l'email.
        $email = $req->getParam('email');

        try {
            // Controllo la validità dei campi ed inserisco l'utente.
            if (
                Validator::isValidName($name)
                && Validator::isValidLastName($lastname)
                && Validator::isValidEmail($email)
                && Users::insert($email, $name, $lastname)
            ) {
                // Ritorno una richiesta con stato 200.
                return $res->withStatus(200);
            }
        } catch (\Exception $e) {
            // Ritorno una richiesta con stato 500 - Internal Server Error e un errore.
            return $res->withStatus(500)->withText($e->getMessage());
        }
        // Ritorno una richiesta con stato 400 - Bad Request.
        return $res->withStatus(400);
    }

    /**
     * Metodo utilizzato per aggiornare i permessi di un utente.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function update(Request $req, Response $res)
    {
        // Ricavo l'email dell'utente da aggiornare.
        $email = $req->getAttribute('email');
        // Ricavo il livello di permessi.
        $permission = $req->getParam('permission') ?? 0;
        // Controllo se l'utente è diverso da quello corrente ed aggiorno i permessi.
        if ($email != $_SESSION["email"] && Users::update($email, $permission)) {
            // Ritorno una richiesta con stato 200.
            return $res->withStatus(200);
        }
        // Ritorno una richiesta con stato 400 - Bad Request.
        return $res->withStatus(400);
    }

    /**
     * Metodo utilizzato per eliminare un utente.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function delete(Request $req, Response $res)
    {
        // Ricavo l'email dell'utente da eliminare.
        $email = $req->getAttribute('email');
        // Controllo se l'utente è diverso da quello corrente e lo elimino.
        if ($email != $_SESSION["email"] && Users::delete($email)) {
            // Ritorno una richiesta con stato 200.
            return $res->withStatus(200);
        }
        // Ritorno una richiesta con stato 400 - Bad Request.
        return $res->withStatus(400);
    }
}
