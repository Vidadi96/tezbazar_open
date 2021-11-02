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
  <br>';

if($statistic_type == 'check'):

    $html .= '<h3>'.$this->langs->by_check.':</h3>
              <br>';

    $obj_pdf->writeHTML($html, true, false, true, false, '');

		$html = '<table class="orderTable" border="1" style="padding: 2px 5px">
			<tr>
				<th width="4%">#</th>
				<th width="8%">'.$this->langs->check.'</th>
				<th width="13%">'.$this->langs->date2.'</th>
				<th width="12%">'.$this->langs->sum_total.'</th>
				<th width="34%">'.$this->langs->product_name.'</th>
				<th width="9%">'.$this->langs->count.'</th>
				<th width="10%">'.$this->langs->price.'</th>
				<th width="10%">'.$this->langs->total.'</th>
			</tr>';

			$i=0;
			foreach($statistic_checks as $row):
				$i++;

				$product_list = $this->PagesModel->pdf_list($row->order_number, $this->session->userdata('lang_id'));

				$j=1;
				foreach($product_list as $raw):
					$html .= '<tr style="height: 40px !important">';

					if($j==1)
						$html .= '<td rowspan="'.count($product_list).'">'.$i.'</td>
											<td rowspan="'.count($product_list).'">#'.$row->order_number.'</td>
											<td rowspan="'.count($product_list).'">'.$row->date_time.'</td>
											<td rowspan="'.count($product_list).'">'.$row->price.' azn</td>';

					$html .= '<td>'.$raw->title.' - '.$raw->description.'</td>
										<td>'.$raw->count.'</td>
										<td>'.$raw->ex_price.' azn</td>
										<td>'.$raw->count*$raw->ex_price.' azn</td>
									</tr>';
					$j++;
				endforeach;
			endforeach;

	 $html .= '</table>';
	 $obj_pdf->writeHTML($html, true, false, true, false, '');

elseif($statistic_type == 'product'):

      $html .= '<h3>'.$this->langs->by_products.':</h3>
                <br>';

      $obj_pdf->writeHTML($html, true, false, true, false, '');

      $html = '<table class="orderTable" border="1" style="padding: 2px 5px">
        <tr>
          <th width="6%">#
            <i class="fa fa-chevron-down" aria-hidden="true"></i>
          </th>
          <th width="38%" colspan="2">'.$this->langs->product.'</th>
					<th width="14%">'.$this->langs->price.'</th>
          <th width="14%">'.$this->langs->bought_times.'</th>
          <th width="14%">'.$this->langs->count.'</th>
          <th width="14%">'.$this->langs->total.'</th>
        </tr>';

        $i=0;
        foreach($statistic_products as $row):
          $i++;

          $html .= '<tr style="height: 40px !important">
            <td>'.$i.'</td>
            <td width="10%">
              <img src="/img/products/95x95/'.$row->img.'" width="40" height="60">
            </td>
						<td width="28%">
							<span> '.$row->title.' - '.$row->description.'</span>
						</td>
						<td></td>
            <td>'.$row->count.'</td>
            <td>'.$row->sum_count.'</td>
            <td>'.$row->price.' azn</td>
            <td>
              <i class="fa fa-angle-down" aria-hidden="true"></i>
            </td>
          </tr>';
					$data = $this->PagesModel->get_opening_list($row->product_id, $date_start, $date_end, $admin);
          $j=0;
          foreach($data as $raw):
            $j++;
            $html .= '<tr style="background: #F5F5F5">
						            <td><u>#'.$raw->order_number.'</u></td>
						            <td colspan="2">'.$raw->date_time.'</td>
						            <td>'.$raw->ex_price.' azn</td>
												<td></td>
						            <td>'.$raw->count.'</td>
						            <td colspan="2">'.number_format($raw->ex_price*$raw->count, 2).' azn</td>
					            </tr>';
        endforeach;
                endforeach;
     $html .= '</table>';

     $obj_pdf->writeHTML($html, true, false, true, false, '');

endif;

ob_end_clean();

$obj_pdf->Output('output.pdf', 'I');
?>
