<?php

namespace FilippoFinke\Models;

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
        // Stampo GESTIONE RITARDI nell'header.
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
        // Aggiungo il contatore del numero di pagina.
        $this->Cell(-18, 10, 'Pagina ' . $this->PageNo() . ' di {nb}', 0, 0, 'C');
        $this->SetX(14);
        // Aggiungo la data corrente.
        $this->Cell(10, 10, date("d.m.Y"), 0, 0, 'C');
    }
    
}
