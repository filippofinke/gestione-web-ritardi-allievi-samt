<?php

namespace FilippoFinke\Controllers;

use Exception;
use FilippoFinke\Request;
use FilippoFinke\Response;
use FilippoFinke\Models\Sections;
use FilippoFinke\Libs\Validator;

/**
 * Section.php
 * Controller che si occupa di gestire tutti i percorsi relativi alla modifica delle sezioni.
 *
 * @author Filippo Finke
 */
class Section
{

    /**
     * Metodo utilizzato per creare una sezione.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function insert(Request $req, Response $res)
    {
        $name = $req->getParam('name');
        try {
            if (Validator::isValidSection($name) && Sections::insert($name)) {
                return $res->withStatus(200);
            }
        } catch (Exception $e) {
            return $res->withStatus(500)->withText($e->getMessage());
        }
        return $res->withStatus(400);
    }

    /**
     * Metodo utilizzato per eliminare una sezione.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function delete(Request $req, Response $res)
    {
        $name = $req->getAttribute('name');
        if (Sections::delete(urldecode($name))) {
            return $res->withStatus(200);
        }
        return $res->withStatus(400);
    }
}
