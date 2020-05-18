<?php

namespace FilippoFinke\Controllers;

use Exception;
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
        $start_first_semester = $req->getParam("start_first_semester");
        $end_first_semester = $req->getParam("end_first_semester");
        $start_second_semester = $req->getParam("start_second_semester");
        $end_second_semester = $req->getParam("end_second_semester");

        if (Validator::isValidSemester($start_first_semester, $end_first_semester, $start_second_semester, $end_second_semester)) {
            try {
                $result = Years::insert($start_first_semester, $end_first_semester, $start_second_semester, $end_second_semester);
                if ($result != false) {
                    return $res->withStatus(200)->withText($result);
                }
            } catch (Exception $e) {
                return $res->withStatus(500)->withText($e->getMessage());
            }
        }

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
        $id = $req->getAttribute('id');
        if (Years::delete($id)) {
            return $res->withStatus(200);
        }
        return $res->withStatus(400);
    }
}
