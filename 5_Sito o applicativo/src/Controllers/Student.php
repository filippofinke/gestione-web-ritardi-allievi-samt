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
        // Ricavo il nome.
        $name = trim($req->getParam('name'));
        // Ricavo il cognome.
        $lastname = trim($req->getParam('lastname'));
        // Ricavo l'email.
        $email = $req->getParam('email');
        // Ricavo la sezione.
        $section = $req->getParam('section');

        try {
            // Controllo la validità dell'email.
            if (!Validator::isValidEmail($email, 'samtrevano.ch')) {
                throw new Exception("L'email deve terminare con @samtrevano.ch!");
            }
            // Controllo la validità dei campi ed inserisco lo studente.
            if (
                Validator::isValidName($name)
                && Validator::isValidLastName($lastname)
                && Validator::isValidSection($section)
                && Students::insert($email, $name, $lastname, $section)
            ) {
                // Ritorno una richiesta con stato 200 - Success e l'id dello studente.
                return $res->withStatus(200)->withText(Database::getConnection()->lastInsertId());
            }
        } catch (Exception $e) {
            // Ritorno una richiesta con stato 500 - Internal Server Error e un errore.
            return $res->withStatus(500)->withText($e->getMessage());
        }
        // Ritorno una richiesta con stato 400 - Bad Request.
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
        // Ricavo l'id dello studente.
        $id = $req->getAttribute('id');
        // Creo il PDF personale.
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
        // Ricavo l'id dello studente.
        $id = $req->getAttribute('id');
        // Ricavo la tipologia di ritardi da mostrare.
        $type = $req->getAttribute('type');
        $delays = [];
        if ($type == "recoveries") {
            // Ricavo i ritardi da recuperare.
            $delays = Delays::getToRecoverById($id);
        } else {
            // Ricavo tutti i ritardi.
            $delays = Delays::getById($id);
        }
        // Ritorno una richiesta con stato 200 - Success con la lista dei ritardi.
        return $res->withStatus(200)->withJson($delays);
    }
}
