<?php

namespace FilippoFinke\Models;

/**
 * RecoveriesPDF.php
 * Classe utilizzata per la generazione di PDF.
 *
 * @author Filippo Finke
 */

class RecoveriesPDF extends PDF
{
    /**
     * Metodo costruttore che si occupa di generare la struttura del PDF.
     *
     * @param $students La lista di studenti.
     */
    public function __construct($students)
    {
        parent::__construct();

        $this->AliasNbPages();
        $this->AddPage('L');

        $this->SetFont('Arial', 'B', 15);
        $this->Cell(
            $this->GetPageWidth() - 20,
            7,
            "Studenti che hanno dei ritardi da recuperare."
        );
        $this->Ln(10);

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(87, 7, "Email", 1);
        $this->Cell(100, 7, "Studente", 1);
        $this->Cell(30, 7, "Sezione", 1);
        $this->Cell(30, 7, "Ritardi", 1);
        $this->Cell(30, 7, "Da recuperare", 1);
        $this->Ln();
        $this->SetFont('Arial', '', 12);

        foreach ($students as $student) {

            $y = $this->GetY();
            $this->MultiCell(87, 7,  $student["email"], 1);
            $h = $this->GetY() - $y;
            $this->SetY($y);
            $this->SetX(97);
            $this->Cell(100, $h, $student["name"] . " " . $student["last_name"], 1);
            $this->Cell(30, $h, $student["section"], 1);
            $this->Cell(30, $h, count($student["delays"]), 1);
            $this->Cell(30, $h, count($student["to_recover"]), 1);
            $this->Ln($h);
        }
        $this->Output('I', "Recuperi.pdf", true);
    }
}
