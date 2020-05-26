<?php

namespace FilippoFinke\Controllers;

use Exception;
use FilippoFinke\Libs\Validator;
use FilippoFinke\Models\Students;
use FilippoFinke\Models\Delays;
use FilippoFinke\Models\StudentPDF;
use FilippoFinke\Request;
use FilippoFinke\Response;
use FilippoFinke\Utils\Database;

/**
 * Student.php
 * Controller che si occupa di gestire tutti i percorsi relativi alla modifica dei dati degli studenti.
 *
 * @author Filippo Finke
 */
class Student
{
    /**
     * Metodo utilizzato per creare uno studente.
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
        $section = $req->getParam('section');

        try {
            if (!Validator::isValidEmail($email, 'samtrevano.ch')) {
                throw new Exception("L'email deve terminare con @samtrevano.ch!");
            }
            if (
                Validator::isValidName($name)
                && Validator::isValidLastName($lastname)
                && $section
                && Students::insert($email, $name, $lastname, $section)
            ) {
                return $res->withStatus(200)->withText(Database::getConnection()->lastInsertId());
            }
        } catch (Exception $e) {
            return $res->withStatus(500)->withText($e->getMessage());
        }
        return $res->withStatus(400);
    }

    /**
     * Metodo utilizzato per generare il pdf dei ritardi di un utente.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function pdf(Request $req, Response $res)
    {
        $id = $req->getAttribute('id');
        $pdf = new StudentPDF($id);
    }

    /**
     * Metodo utilizzato per ricavare tutti i ritardi di un utente.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function delays(Request $req, Response $res)
    {
        $id = $req->getAttribute('id');
        $type = $req->getAttribute('type');
        $delays = null;
        if ($type == "recoveries") {
            $delays = Delays::getToRecoverById($id);
        } else {
            $delays = Delays::getById($id);
        }
        return $res->withStatus(200)->withJson($delays);
    }
}
