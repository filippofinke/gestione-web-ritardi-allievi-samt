<?php

namespace FilippoFinke\Controllers;

use FilippoFinke\Request;
use FilippoFinke\Response;
use FilippoFinke\Models\Years;
use FilippoFinke\Libs\Validator;

/**
 * Year.php
 * Controller che si occupa di gestire tutti i percorsi relativi alla modifica degli anni.
 *
 * @author Filippo Finke
 */
class Year
{
    /**
     * Metodo utilizzato per inserire un anno scolastico.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function insert(Request $req, Response $res)
    {
        // Ricavo la data di inizio del primo semestre.
        $start_first_semester = $req->getParam("start_first_semester");
        // Ricavo la data di fine del primo semestre.
        $end_first_semester = $req->getParam("end_first_semester");
        // Ricavo la data di inizio del secondo semestre.
        $start_second_semester = $req->getParam("start_second_semester");
        // Ricavo la data di fine del secondo semestre.
        $end_second_semester = $req->getParam("end_second_semester");

        // Controllo la validità dei campi.
        if (Validator::isValidSemester($start_first_semester, $end_first_semester, $start_second_semester, $end_second_semester)) {
            try {
                // Inserisco l'anno e ricavo l'id.
                $result = Years::insert($start_first_semester, $end_first_semester, $start_second_semester, $end_second_semester);
                if ($result != false) {
                    // Ritorno una richiesta con stato 200 - Success e l'id dell'anno scolastico.
                    return $res->withStatus(200)->withText($result);
                }
            } catch (\Exception $e) {
                // Ritorno una richiesta con stato 500 - Internal Server Error e un errore.
                return $res->withStatus(500)->withText($e->getMessage());
            }
        }
        // Ritorno una richiesta con stato 400 - Bad Request.
        return $res->withStatus(400);
    }

    /**
     * Metodo utilizzato per eliminare un anno scolastico.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function delete(Request $req, Response $res)
    {
        // Ricavo l'id dell'anno scolastico da eliminare.
        $id = $req->getAttribute('id');
        // Elimino l'anno scolastico.
        if (Years::delete($id)) {
            // Ritorno una richiesta con stato 200 - Success.
            return $res->withStatus(200);
        }
        // Ritorno una richiesta con stato 400 - Bad Request.
        return $res->withStatus(400);
    }
}
