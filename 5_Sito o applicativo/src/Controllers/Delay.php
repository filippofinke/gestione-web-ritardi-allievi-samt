<?php

namespace FilippoFinke\Controllers;

use FilippoFinke\Request;
use FilippoFinke\Response;
use FilippoFinke\Models\Delays;

/**
 * Delay.php
 * Controller che si occupa di gestire tutti i percorsi relativi alla modifica dei ritardi.
 *
 * @author Filippo Finke
 */
class Delay
{

    /**
     * Metodo utilizzato per inserire un ritardo.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function insert(Request $req, Response $res)
    {
        $id = $req->getParam('id');
        $date = $req->getParam('date');
        $observations = $req->getParam('observations') ?? null;
        $justified = $req->getParam('justified') ?? 0;
        try {
            $result = Delays::insert($id, $date, htmlspecialchars($observations), $justified);
            if ($result) {
                return $res->withStatus(200)->withText($result);
            }
        } catch (\Exception $e) {
            return $res->withStatus(500)->withText($e->getMessage());
        }
        return $res->withStatus(400);
    }

    /**
     * Metodo utilizzato per aggiornare un ritardo.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function update(Request $req, Response $res)
    {
        $id = $req->getAttribute('id');
        $date = $req->getParam('date');
        if ($date && Delays::update($id, $date)) {
            return $res->withStatus(200);
        }
        return $res->withStatus(400);
    }

    /**
     * Metodo utilizzato per eliminare un ritardo.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function delete(Request $req, Response $res)
    {
        $id = $req->getAttribute('id');
        if (Delays::delete($id)) {
            return $res->withStatus(200);
        }
        return $res->withStatus(400);
    }
}
