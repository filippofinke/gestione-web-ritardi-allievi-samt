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
        // Ricavo l'id dello studente al quale inserire il ritardo.
        $id = $req->getParam('id');
        // Ricavo la data del ritardo.
        $date = $req->getParam('date');
        // Ricavo le osservazioni del ritardo.
        $observations = $req->getParam('observations');
        // Ricavo lo stato del ritardo.
        $justified = $req->getParam('justified') ?? 0;

        try {
            // Provo ad inserire il ritardo nel database.
            $result = Delays::insert($id, $date, htmlspecialchars($observations), $justified);
            if ($result) {
                // Ritorno una richiesta con stato 200 - Success e l'identificativo del ritardo.
                return $res->withStatus(200)->withText($result);
            }
        } catch (\Exception $e) {
            // Ritorno una richiesta con stato 500 - Internal Server Error e un errore.
            return $res->withStatus(500)->withText($e->getMessage());
        }
        // Ritorno una richiesta con stato 400 - Bad Request.
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
        // Ricavo l'id del ritardo dalla richiesta.
        $id = $req->getAttribute('id');
        // Ricavo la data del recupero del ritardo.
        $date = $req->getParam('date');
        // Controllo la presenza della data ed aggiorno il ritardo.
        if ($date && Delays::update($id, $date)) {
            // Ritorno una richiesta con stato 200 - Success.
            return $res->withStatus(200);
        }
        // Ritorno una richiesta con stato 400 - Bad Request.
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
        // Ricavo l'id del ritardo dalla richiesta.
        $id = $req->getAttribute('id');
        // Elimino il ritardo.
        if (Delays::delete($id)) {
            // Ritorno una richiesta con stato 200 - Success.
            return $res->withStatus(200);
        }
        // Ritorno una richiesta con stato 400 - Bad Request.
        return $res->withStatus(400);
    }
}
