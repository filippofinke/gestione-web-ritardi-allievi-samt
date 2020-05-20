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

class PDF extends \Fpdf\Fpdf
{

    /**
     * Metodo che genera l'intestazione del file PDF.
     */
    public function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(($this->GetPageWidth() - 20), 7, 'GESTIONE RITARDI', 'B', 0, 'T');
        $this->Ln(12);
    }

    /**
     * Metodo che genera il piè di pagina del file PDF.
     */
    public function Footer()
    {
        $this->SetY(-17);
        $this->Cell(($this->GetPageWidth() - 20), 0, '', 'T');
        $this->SetFont('Arial', '', 10);
        $this->Cell(-18, 10, 'Pagina ' . $this->PageNo() . ' di {nb}', 0, 0, 'C');
        $this->SetX(14);
        $this->Cell(10, 10, date("d.m.Y"), 0, 0, 'C');
    }

    /**
     * Metodo costruttore che si occupa di generare la struttura del PDF.
     *
     * @param $email L'email dello studente.
     */
    public function __construct($email)
    {
        parent::__construct();

        $student = Students::getByEmail($email);
        if (!$student) exit;
        $semester = Years::getCurrentSemester();
        $delays = Delays::getInCurrentSemesterByEmail($email);
        $to_recover = Delays::getToRecoverByEmail($email);
        $semester[0] = date("d.m.Y", strtotime($semester[0]));
        $semester[1] = date("d.m.Y", strtotime($semester[1]));
        $this->AliasNbPages();
        $this->AddPage('L');

        $this->SetFont('Arial', 'B', 15);
        $this->Cell(
            $this->GetPageWidth() - 20,
            7,
            "Ritardi di " . $student["name"] . " " . $student["last_name"] . " dal " . $semester[0] . " al " . $semester[1] . "."
        );
        $this->Ln(7);
        $this->SetFont('Arial', '', 15);
        $this->Cell(
            $this->GetPageWidth() - 20,
            7,
            "Ritardi nel semestre: " . count($delays) . ", da recuperare: " . count($to_recover) . "."
        );
        $this->Ln(10);

        $this->SetFont('Arial', 'B', 12);

        $this->Cell(25, 7, "Data", 1);
        $this->Cell(25, 7, "Recupero", 1);
        $this->Cell(25, 7, "Giustificato", 1);
        $this->Cell(202, 7, "Osservazioni", 1);
        $this->Ln();
        $this->SetFont('Arial', '', 12);

        foreach ($delays as $delay) {
            $this->Cell(25, 7, $delay["date"], 1);
            $this->Cell(25, 7, $delay["recovered"] ?? "No", 1);
            $this->Cell(25, 7, ($delay["justified"]) ? "Si" : "No", 1);
            $this->MultiCell(202, 7, $delay["observations"], 1);
        }
        $this->Output('I', $student["name"] . $student["last_name"] . ".pdf", true);
    }
}
