<?php
tcpdf();
$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$obj_pdf->SetCreator(PDF_CREATOR);
$title = "PDF Report";
$obj_pdf->SetTitle($title);
$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$obj_pdf->setFontSubsetting(false);
$obj_pdf->setPrintHeader(false);
$obj_pdf->setPrintFooter(false);
$obj_pdf->setFont('freeserif');
$obj_pdf->AddPage();
ob_start();

$html = '
	<table>
		<tr>
			<td width="20%" style="font-size: 14px;">
      </td>
      <td width="20%"></td>
      <td width="35%"></td>
			<td width="25%">
        <img height="36px" src="/assets/img/logo_tezbazar.png" >
      </td>
		</tr>
  </table>
  <h2>'.$this->langs->statistics.'</h2>
  <br>

  <h3>'.$this->langs->by_category.':</h3>
  <br>';

    $obj_pdf->writeHTML($html, true, false, true, false, '');

    $obj_pdf->cell(1);
    $obj_pdf->SetFontSize(12);
    $obj_pdf->SetFont('', 'B');
    $obj_pdf->Cell(50, 10, $this->langs->category_name, 'LTRB', 0, 'C', FALSE);
    $obj_pdf->Cell(30, 10, $this->langs->waste, 'LTRB', 1, 'C', FALSE);


    foreach($first_diagram as $row){

        $obj_pdf->cell(1);
        $obj_pdf->SetFontSize(12);
        $obj_pdf->SetFont('', '');
        $obj_pdf->Cell(50, 10, $row->name, 'LTRB', 0, 'C', FALSE);
        $obj_pdf->Cell(30, 10, $row->price." azn", 'LBR', 1, 'C', FALSE);
    }

    $html2 = '<br>
              <h3>'.$this->langs->by_date.':</h3>
              <br>';
    $obj_pdf->writeHTML($html2, true, false, true, false, '');

    $obj_pdf->cell(1);
    $obj_pdf->SetFontSize(12);
    $obj_pdf->SetFont('', 'B');
    $obj_pdf->Cell(30, 10, $this->langs->month, 'LTRB', 0, 'C', FALSE);
    $obj_pdf->Cell(30, 10, $this->langs->waste, 'LTRB', 1, 'C', FALSE);

    $total = 0;
    foreach($second_diagram as $row){
    $total = $total + $row->price;
        $obj_pdf->cell(1);
        $obj_pdf->SetFontSize(12);
        $obj_pdf->SetFont('', '');
        $obj_pdf->Cell(30, 10, $row->date_time, 'LTRB', 0, 'C', FALSE);
        $obj_pdf->Cell(30, 10, $row->price." azn", 'LBR', 1, 'C', FALSE);
    }

    $html3 = '<br>
              <h3>'.$this->langs->total.':</h3>
              <br>';
    $obj_pdf->writeHTML($html3, true, false, true, false, '');

    $obj_pdf->cell(1);
    $obj_pdf->SetFontSize(12);
    $obj_pdf->SetFont('', 'B');
		$obj_pdf->MultiCell(30, 12, $this->langs->total_waste, 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M', true);
    $obj_pdf->MultiCell(30, 12, $this->langs->number_of_purchases, 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M', true);
    $obj_pdf->MultiCell(40, 12, $this->langs->waiting_a_proposal, 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M', true);
    $obj_pdf->MultiCell(40, 12, $this->langs->pending_confirmation, 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M', true);
    $obj_pdf->MultiCell(40, 12, $this->langs->number_of_refusals, 1, 'C', 0, 1, '', '', true, 0, false, true, 0, 'M', true);


    $obj_pdf->cell(1);
    $obj_pdf->SetFontSize(12);
    $obj_pdf->SetFont('', '');
    $obj_pdf->Cell(30, 10, $total." azn", 'LTRB', 0, 'C', FALSE);
    $obj_pdf->Cell(30, 10, $success_order_count, 'LTRB', 0, 'C', FALSE);
    $obj_pdf->Cell(40, 10, $waiting_proposal, 'LTRB', 0, 'C', FALSE);
    $obj_pdf->Cell(40, 10, $waiting_confirmation, 'LTRB', 0, 'C', FALSE);
    $obj_pdf->Cell(40, 10, $cancelled_order_count, 'LBR', 1, 'C', FALSE);

ob_end_clean();

$obj_pdf->Output('output.pdf', 'I');
?>
