<?php

namespace FilippoFinke\Models;

use FilippoFinke\Models\Students;
use FilippoFinke\Models\Years;
use FilippoFinke\Models\Delays;

/**
 * PDF.php
 * Classe utilizzata per la generazione di PDF.
 *
 * @author Filippo Finke
 */

class StudentPDF extends PDF
{
    /**
     * Metodo costruttore che si occupa di generare la struttura del PDF.
     *
     * @param $id L'id dello studente.
     */
    public function __construct($id)
    {
        parent::__construct();

        // Ricavo l'anno corrente.
        $year = Years::getCurrentYear();
        // Ricavo lo studente.
        $student = Students::getById($id);
        if (!$student) exit;
        // Attivo i numeri di pagina.
        $this->AliasNbPages();
        $this->AddPage('L');

        $this->SetFont('Arial', 'B', 15);
        $header = "";
        if ($student["year"] == $year["id"]) {
            // Ricavo solamente i ritardi nel semestre.

            $semester = Years::getCurrentSemester();
            $delays = Delays::getInCurrentSemesterById($id);
            $to_recover = Delays::getToRecoverById($id);
            $semester[0] = date("d.m.Y", strtotime($semester[0]));
            $semester[1] = date("d.m.Y", strtotime($semester[1]));
            $header = " dal " . $semester[0] . " al " . $semester[1] . ".";
            $subtitle = "Ritardi nel semestre: ";
        } else {
            // Ricavo lo storico.
            
            $delays = Delays::getById($id);
            $to_recover = Delays::getToRecoverById($id);
            $year = Years::getYearById($student["year"]);
            $header = " storico anno " . date("Y", strtotime($year["start_first_semester"])) . "/" . date("Y", strtotime($year["end_second_semester"])) . ".";
            $subtitle = "Ritardi totali: ";
        }

        // Aggiungo l'header al file.
        $this->Cell(
            $this->GetPageWidth() - 20,
            7,
            "Ritardi di " . $student["name"] . " " . $student["last_name"] . $header
        );
        $this->Ln(7);
        $this->SetFont('Arial', '', 15);
        $this->Cell(
            $this->GetPageWidth() - 20,
            7,
            $subtitle . count($delays) . ", da recuperare: " . count($to_recover) . "."
        );
        $this->Ln(10);

        $this->SetFont('Arial', 'B', 12);

        // Stampo i nomi delle colonne.
        $this->Cell(25, 7, "Data", 1);
        $this->Cell(25, 7, "Recupero", 1);
        $this->Cell(25, 7, "Giustificato", 1);
        $this->Cell(202, 7, "Osservazioni", 1);
        $this->Ln();
        $this->SetFont('Arial', '', 12);

        // Stampo i ritardi.
        foreach ($delays as $delay) {

            $length = strlen($delay["observations"]);

            // Creo l'altezza della cella dinamicamente.
            $cellHeight = 7;
            $cellHeight += $length > 87 ? 7 : 0;
            $cellHeight += $length > 174 ? 7 : 0;

            $this->Cell(25, $cellHeight, $delay["date"], 1);
            $this->Cell(25, $cellHeight, $delay["recovered"] ?? "No", 1);
            $this->Cell(25, $cellHeight, ($delay["justified"]) ? "Si" : "No", 1);
            $this->MultiCell(202, 7, $delay["observations"], 1);
        }
        $this->Output('I', $student["name"] . $student["last_name"] . ".pdf", true);
    }
}
