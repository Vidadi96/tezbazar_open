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
        <u>#'.$users->order_number.'</u>
      </td>
      <td width="20%"></td>
      <td width="35%"></td>
			<td width="25%">
        <img height="36px" src="/assets/img/logo_tezbazar.png" >
      </td>
		</tr>
  </table>';

  $html .= '
    <br>
    <br>
  	<table>
  		<tr>
  			<td width="25%" style="font-size: 14px;">
          '.$users->company_name.'
        </td>
        <td width="15%"></td>
        <td width="35%"></td>
  			<td width="25%"></td>
  		</tr>
    </table>
    <br>
    <br>
    <br>
    <br>';
    $obj_pdf->writeHTML($html, true, false, true, false, '');

    $obj_pdf->cell(1);
    $obj_pdf->SetFontSize(12);
    $obj_pdf->SetFont('', 'B');
    $obj_pdf->Cell(10, 10, '#', 'LTRB', 0, 'C', FALSE);
    $obj_pdf->Cell(70, 10, $this->langs->name, 'LTRB', 0, 'C', FALSE);
		$obj_pdf->Cell(27, 10, $this->langs->count, 'LTRB', 0, 'C', FALSE);
    $obj_pdf->Cell(27, 10, $this->langs->price, 'LTRB', 0, 'C', FALSE);
    $obj_pdf->Cell(25, 10, $this->langs->sum, 'LTRB', 1, 'C', FALSE);

    $i=0;
    $total = 0;
    foreach($pdf_list as $row){
    $i++;
    $total = $total + $row->ex_price*$row->count;
		$textLength = strlen($row->title." - ".$row->description);
    $rowheight = 7;
    if($textLength > 228)
      $rowheight = 49;
    else if($textLength > 190)
      $rowheight = 42;
    else if($textLength > 152)
      $rowheight = 35;
    else if($textLength > 114)
      $rowheight = 28;
    else if($textLength > 76)
      $rowheight = 21;
    else if ($textLength > 38)
      $rowheight = 14;

        $obj_pdf->cell(1);
        $obj_pdf->SetFontSize(12);
        $obj_pdf->SetFont('', '');
        $obj_pdf->Cell(10, $rowheight, $i, 'LBR', 0, 'C', FALSE);
				$obj_pdf->MultiCell(70, $rowheight, $row->title." - ".$row->description, 1, '', 0, 0, '', '', true, 0, false, true, 0, 'M', true);
				$obj_pdf->Cell(27, $rowheight, $row->count, 'LBR', 0, 'C', FALSE);
        $obj_pdf->Cell(27, $rowheight, $row->ex_price." azn", 'LBR', 0, 'C', FALSE);
        $obj_pdf->Cell(25, $rowheight, number_format($row->ex_price*$row->count, 2)." azn", 'LBR', 1, 'C', FALSE);
    }

    $html2 = '<br><br><br><span> <b>'.$this->langs->total2.':</b> '.number_format($total, 2).' azn</span>';
    $obj_pdf->writeHTML($html2, true, false, true, false, '');

ob_end_clean();

$obj_pdf->Output('output.pdf', 'I');
?>
