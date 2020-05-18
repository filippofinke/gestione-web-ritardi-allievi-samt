<?php

namespace FilippoFinke\Controllers;

use Exception;
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
        $name = $req->getParam('name');
        $lastname = $req->getParam('lastname');
        $email = $req->getParam('email');

        try {
            if (
                Validator::isValidName($name)
                && Validator::isValidLastName($lastname)
                && Validator::isValidEmail($email)
                && Users::insert($email, $name, $lastname)
            ) {
                return $res->withStatus(200);
            }
        } catch (Exception $e) {
            return $res->withStatus(500)->withText($e->getMessage());
        }
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
        $email = $req->getAttribute('email');
        $permission = $req->getParam('permission') ?? 0;
        if ($email != $_SESSION["email"] && Users::update($email, $permission)) {
            return $res->withStatus(200);
        }
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
        $email = $req->getAttribute('email');
        if ($email != $_SESSION["email"] && Users::delete($email)) {
            return $res->withStatus(200);
        }
        return $res->withStatus(400);
    }
}
