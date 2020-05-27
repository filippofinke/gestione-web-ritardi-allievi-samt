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
        // Ricavo l'anno scolastico corrente.
        $currentYear = Years::getCurrentYear();
        // Se l'anno è presente ne assegno l'id.
        if ($currentYear) $currentYearId = $currentYear["id"];
        // Ricavo l'anno richiesto dall'utente.
        $year = $req->getAttribute('year');
        // Se non è richiesto nessun anno imposto quello corrente.
        if (!$year) $year = $currentYearId;
        // Ricavo tutti gli studenti dell'anno selezionato.
        $students = Students::getByYear($year);
        // Ricavo dati aggiuntivi per ogni utente.
        foreach ($students as $key => $student) {
            if ($year == $currentYearId) {
                // Ricavo solamente i ritardi del semsetre.
                $students[$key]["delays"] = Delays::getInCurrentSemesterById($student["id"]) ?? [];
            } else {
                // Ricavo lo storico di ritardi.
                $students[$key]["delays"] = Delays::getById($student["id"]);
            }
            // Ricavo i ritardi da recuperare.
            $students[$key]["to_recover"] = Delays::getToRecoverById($student["id"]) ?? [];
        }

        // Ricavo tutte le sezioni scolastiche.
        $sections = Sections::getAll();
        // Ricavo informazioni sull'anno selezionato.
        $selectedYear = Years::getYearById($year);
        // Carico la pagina di gestione dei ritardi.
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
        // Ricavo tutti gli studenti.
        $students = Students::getAll();
        // Ricavo informazioni aggiuntive per ogni studente.
        foreach ($students as $key => $student) {
            // Ricavo i ritardi da recuperare.
            $to_recover = Delays::getToRecoverById($student["id"]) ?? [];
            // Se non ha dei ritardi da recuperare scarto l'utente.
            if (count($to_recover) == 0) {
                unset($students[$key]);
                continue;
            }
            // Aggiungo i ritardi normali.
            $students[$key]["delays"] = Delays::getInCurrentSemesterById($student["id"]) ?? [];
            // Aggiungo i ritardi da recuperare.
            $students[$key]["to_recover"] = $to_recover;
        }
        // Carico la pagina di gestione recuperi.
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
        // Ricavo tutti gli studenti.
        $students = Students::getAll();
        // Per ogni studente ricavo informazioni supplementari.
        foreach ($students as $key => $student) {
            // Ricavo i ritardi da recuperare.
            $to_recover = Delays::getToRecoverById($student["id"]);
            // Se non ha dei ritardi da recuperare scarto l'utente.
            if (count($to_recover) == 0) {
                unset($students[$key]);
                continue;
            }
            // Aggiungo i ritardi normali.
            $students[$key]["delays"] = Delays::getInCurrentSemesterById($student["id"]);
            // Aggiungo i ritardi da recuperare.
            $students[$key]["to_recover"] = $to_recover;
        }
        // Creo il pdf con la lista di studenti.
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
        // Ricavo tutti gli utenti.
        $users = Users::getAll();
        // Carico la pagina di gestione utenti.
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
        // Ricavo tutte le impostazioni.
        $settings = Settings::getAll();
        // Ricavo tutte le sezioni.
        $sections = Sections::getAll();
        // Ricavo tutti gli anni.
        $years = Years::getAll();
        // Carico la pagina delle impostazioni.
        return $res->render(__DIR__ . '/../Views/Home/settings.php', array("settings" => $settings, "sections" => $sections, "years" => $years));
    }
}
