<?php

namespace FilippoFinke\Controllers;

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
        // Ricavo il nome della nuova sezione.
        $name = $req->getParam('name');
        try {
            // Controllo il nome della sezione e provo ad inserirla.
            if (Validator::isValidSection($name) && Sections::insert($name)) {
                // Ritorno una richiesta con stato 200 - Success.
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
     * Metodo utilizzato per eliminare una sezione.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function delete(Request $req, Response $res)
    {
        // Ricavo il nome della sezione da eliminare.
        $name = $req->getAttribute('name');
        // Elimino la sezione.
        if (Sections::delete(urldecode($name))) {
            // Ritorno una richiesta con stato 200 - Success.
            return $res->withStatus(200);
        }
        // Ritorno una richiesta con stato 400 - Bad Request.
        return $res->withStatus(400);
    }
}
