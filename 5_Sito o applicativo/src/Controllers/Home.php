<?php

namespace FilippoFinke\Controllers;

use FilippoFinke\Request;
use FilippoFinke\Response;
use FilippoFinke\Models\Users;
use FilippoFinke\Models\Years;
use FilippoFinke\Models\RecoveriesPDF;
use FilippoFinke\Models\Delays;
use FilippoFinke\Models\Sections;
use FilippoFinke\Models\Settings;
use FilippoFinke\Models\Students;

/**
 * Home.php
 * Controller che si occupa di gestire tutti i percorsi della dashboard del sito.
 *
 * @author Filippo Finke
 */
class Home
{
    /**
     * Metodo che si occupa di renderizzare la pagina dei ritardi.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function delays(Request $req, Response $res)
    {
        $currentYearId = Years::getCurrentYear();
        if ($currentYearId) $currentYearId = $currentYearId["id"];
        $year = $req->getAttribute('year');
        if (!$year) $year = $currentYearId;

        $students = Students::getByYear($year);
        foreach ($students as $key => $student) {
            if ($year == $currentYearId) {
                $students[$key]["delays"] = Delays::getInCurrentSemesterById($student["id"]) ?? [];
            } else {
                $students[$key]["delays"] = Delays::getById($student["id"]);
            }
            $students[$key]["to_recover"] = Delays::getToRecoverById($student["id"]) ?? [];
        }

        $sections = Sections::getAll();
        $selectedYear = Years::getYearById($year);
        return $res->render(
            __DIR__ . '/../Views/Home/delays.php',
            array(
                "students" => $students,
                "sections" => $sections,
                "selectedYear" => $selectedYear,
                "canInteract" => ($currentYearId == $year)
            )
        );
    }

    /**
     * Metodo che si occupa di renderizzare la pagina dei recuperi.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function recoveries(Request $req, Response $res)
    {
        $students = Students::getAll();
        foreach ($students as $key => $student) {
            $to_recover = Delays::getToRecoverById($student["id"]) ?? [];
            if (!$to_recover || count($to_recover) == 0) {
                unset($students[$key]);
                continue;
            }
            $students[$key]["delays"] = Delays::getInCurrentSemesterById($student["id"]) ?? [];
            $students[$key]["to_recover"] = $to_recover;
        }
        return $res->render(
            __DIR__ . '/../Views/Home/recoveries.php',
            array("students" => $students)
        );
    }

    /**
     * Metodo che si occupa di renderizzare il pdf la pagina dei recuperi.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function recoveriesPdf(Request $req, Response $res)
    {
        $students = Students::getAll();
        foreach ($students as $key => $student) {
            $to_recover = Delays::getToRecoverById($student["id"]);
            if (count($to_recover) == 0) {
                unset($students[$key]);
                continue;
            }

            $students[$key]["delays"] = Delays::getInCurrentSemesterById($student["id"]);
            $students[$key]["to_recover"] = $to_recover;
        }
        $pdf = new RecoveriesPDF($students);
    }

    /**
     * Metodo che si occupa di renderizzare la pagina di gestione utenti.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function users(Request $req, Response $res)
    {
        $users = Users::getAll();
        return $res->render(__DIR__ . '/../Views/Home/users.php', array("users" => $users));
    }

    /**
     * Metodo che si occupa di renderizzare la pagina di gestione delle impostazioni.
     *
     * @param $request La richiesta effettuata dall'utente.
     * @param $response La risposta da ritornare.
     * @return Response La risposta.
     */
    public static function settings(Request $req, Response $res)
    {
        $settings = Settings::getAll();
        $sections = Sections::getAll();
        $years = Years::getAll();
        return $res->render(__DIR__ . '/../Views/Home/settings.php', array("settings" => $settings, "sections" => $sections, "years" => $years));
    }
}
