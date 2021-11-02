<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reports extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("reports_model");
	}

  public function goods_movement()
  {
		$product_id = $start_date = $end_date = '';
		$category_id = [];

		if($this->input->post())
		{
			$post = $this->input->post();
			$filtered_post = $this->filter_data($post);

			if($this->input->post('product_id'))
				$product_id = (int) $filtered_post['product_id'];

			if($this->input->post('start_date'))
				$start_date = date('Y-m-d H:m:s', (strtotime($filtered_post['start_date'])));

			if($this->input->post('end_date'))
				$end_date = date('Y-m-d H:m:s', (strtotime($filtered_post['end_date'])));

			if($this->input->post('category_id'))
				$category_id = $filtered_post['category_id'];
		}

		$category_id = implode(',', $category_id);

		$from=0;

		if($this->input->get('page'))
		{
			$get = $this->input->get();
			$filtered_get = $this->filter_data($get);
			$from = (int)$filtered_get['page'];
		}

		$count = 15;

		$data["goods_movement_list"] = $this->reports_model->goods_movement_list($from, $count, $product_id, $start_date, $end_date, $category_id, $this->session->userdata('lang_id'));

		$base_url = "/reports/goods_movement";
		$total = $this->reports_model->goods_movement_list_rows($product_id, $start_date, $end_date, $category_id);

		if($total->count >= 1)
			$data["pagination"] = $this->pagination($from, $count, $base_url, $total->count, 3, 4);

		$data['category_id'] = $category_id;
		$data['date_start'] = $start_date;
		$data['date_end'] = $end_date;
		$data['product_id'] = $product_id;
		$pname_arr = $this->reports_model->select_where('title, description', array('p_id' => $product_id, 'lang_id' => $this->session->userdata('lang_id')), 'products');
		$data['product_name'] = ($pname_arr)?$pname_arr[0]->title.' - '.$pname_arr[0]->description:'';
		$data["export_name"] = $this->reports_model->select_where('export_name, export_name_id', array('lang_id' => $this->session->userdata('lang_id')), 'export_name', array('export_name_id', 'asc'));
    $data["products"] = $this->reports_model->get_products($this->session->userdata('lang_id'));
		$data["goods_movement_list_inside"] = $this->reports_model->goods_movement_list_inside($product_id, $start_date, $end_date, $category_id);

    $this->home('reports/goods_movement', $data);
  }

	public function goods_movement_excel()
	{
		$date_start = $date_end = $product_id = $category_id = '';
		$get_data = $this->input->get();
		$filtered_get = $this->filter_data($get_data);

		if($this->input->get('category_id')){
			$category_id = $filtered_get['category_id'];
			$category_id2 = $this->reports_model->select_where_array('name', 'cat_id in ('.$filtered_get['category_id'].') and lang_id = '.$this->session->userdata('lang_id'), 'cats');
			foreach($category_id2 as $row)
				$category_id3[] = $row['name'];
			$category_id2 = implode(',', $category_id3);
		}
		if($this->input->get('product_id'))
			$product_id = $filtered_get['product_id'];
		if($this->input->get('date_start'))
			$date_start = $filtered_get['date_start'];
		if($this->input->get('date_end'))
			$date_end = $filtered_get['date_end'];

		$goods_movement_list = $this->reports_model->goods_movement_list_all($product_id, $date_start, $date_end, $category_id, $this->session->userdata('lang_id'));
		$export_name = $this->reports_model->select_where('export_name, export_name_id', array('lang_id' => $this->session->userdata('lang_id')), 'export_name', array('export_name_id', 'asc'));
    $products = $this->reports_model->get_products($this->session->userdata('lang_id'));
		$goods_movement_list_inside = $this->reports_model->goods_movement_list_inside($product_id, $date_start, $date_end, $category_id);

		$pname_arr = $this->reports_model->select_where('title, description', array('p_id' => $product_id, 'lang_id' => $this->session->userdata('lang_id')), 'products');
		$product_name = $pname_arr?$pname_arr[0]->title.' - '.$pname_arr[0]->description:'';

		$this->load->library('excel');
		$object = new PHPExcel();
		foreach(range('A','L') as $columnID) {
			$object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}

		$styleArray = array(
			'font'  => array(
					'bold'  => true,
					'size'  => 13
			));

		$styleArray1 = array(
			'font'  => array(
					'bold'  => true,
					'size'  => 15
			));

		$styleArray2 = array(
			'font'  => array(
					'bold'  => true,
					'size'  => 12
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			),
			'borders' => array(
				'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
				)
			));

		$styleArray3 = array(
			'font'  => array(
				'size'  => 12
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000')
				)
		));

		$styleArray4 = array(
			'font'  => array(
				'size'  => 12
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			));

		$object->setActiveSheetIndex(0);
		$object->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray1);
		$object->getActiveSheet()->getStyle('A3:D3')->applyFromArray($styleArray);

		$object->getActiveSheet()->setCellValueByColumnAndRow(0, 1, $this->langs->goods_movement);

		$excel_column = 0;
		if ($category_id) {
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 3, $this->langs->category.":");
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 4, $category_id2);
			$excel_column++;
		}

		if ($product_id) {
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 3, $this->langs->product_name.":");
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 4, $product_name);
			$excel_column++;
		}

		if ($date_start) {
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 3, $this->langs->start_date.":");
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 4, $date_start);
			$excel_column++;
		}

		if ($date_end) {
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 3, $this->langs->end_date.":");
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 4, $date_end);
		}

		if($category_id || $product_id || $date_start || $date_end)
			$object->getActiveSheet()->getStyle('A4:D4')->applyFromArray($styleArray4);

		$excel_row = ($category_id || $product_id || $date_start || $date_end)?6:4;
		$excel_array = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
										'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $this->langs->code_of_product);
		$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $this->langs->product_name);
		$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $this->langs->import_price);
		$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $this->langs->export_price);
		$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $this->langs->import);

		$excel_column = 5;
		foreach ($export_name as $row):
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, $excel_row, $row->export_name);
			$excel_column++;
		endforeach;

		$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, $excel_row, $this->langs->balance_amount_import);
		$excel_column++;
		$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, $excel_row, $this->langs->balance_amount_export);
		$object->getActiveSheet()->getStyle('A'.$excel_row.':'.$excel_array[$excel_column].$excel_row)->applyFromArray($styleArray2);

		$excel_row++;

		foreach($goods_movement_list as $row)
		{
			if($row->row_count):
				$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, '#'.$row->sku);
				$object->getActiveSheet()->mergeCells('A'.$excel_row.':A'.($excel_row + $row->row_count - 1));
				$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->name);
				$object->getActiveSheet()->mergeCells('B'.$excel_row.':B'.($excel_row + $row->row_count - 1));
			endif;

			$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->im_price);
			$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->ex_price);
			$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->count);

			$excel_column = 5;
			$b = 0;
			foreach ($export_name as $ruw):
						$a = 0;
						foreach($goods_movement_list_inside as $raw):
							if($raw->import_id == $row->id):
								if($raw->entry_name_id == $ruw->export_name_id):
									$a = $a + $raw->count;
									$b = $b + $raw->count;
								endif;
							endif;
						endforeach;
						$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, $excel_row, $a);
						$excel_column++;
			endforeach;

			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, $excel_row, $row->im_price * ($row->count - $b).' ₼');
			$excel_column++;
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, $excel_row, $row->ex_price * ($row->count - $b).' ₼');
			$object->getActiveSheet()->getStyle('A'.$excel_row.':'.$excel_array[$excel_column].$excel_row)->applyFromArray($styleArray3);
			$excel_row++;
		}

		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');

		ob_start();
		$object_writer->save("php://output");
		$xlsData = ob_get_contents();
		ob_end_clean();

		$response =  array(
				'op' => 'ok',
				'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
		);

		die(json_encode($response));
	}

	public function import_excel()
	{
		$date_start = $date_end = $product_id = $category_id = $provider_id = '';
		$get_data = $this->input->get();
		$filtered_get = $this->filter_data($get_data);

		if($this->input->get('category_id')){
			$category_id = $filtered_get['category_id'];
			$category_id2 = $this->reports_model->select_where_array('name', 'cat_id in ('.$filtered_get['category_id'].') and lang_id = '.$this->session->userdata('lang_id'), 'cats');
			foreach($category_id2 as $row)
				$category_id3[] = $row['name'];
			$category_id2 = implode(',', $category_id3);
		}
		if($this->input->get('product_id'))
			$product_id = $filtered_get['product_id'];
		if($this->input->get('date_start'))
			$date_start = $filtered_get['date_start'];
		if($this->input->get('date_end'))
			$date_end = $filtered_get['date_end'];
		if($this->input->get('provider_id'))
			$provider_id = (int) $filtered_get['provider_id'];

		$import_list = $this->reports_model->import_list_all($product_id, $date_start, $date_end, $category_id, $provider_id, $this->session->userdata('lang_id'), 0);
    $products = $this->reports_model->get_products($this->session->userdata('lang_id'));

		$pname_arr = $this->reports_model->select_where('title, description', array('p_id' => $product_id, 'lang_id' => $this->session->userdata('lang_id')), 'products');
		$product_name = $pname_arr?$pname_arr[0]->title.' - '.$pname_arr[0]->description:'';

		$salesman_arr = $this->reports_model->select_where('fullname', array('id' => $provider_id), 'salesmen');
		$salesman = $salesman_arr?$salesman_arr[0]->fullname:'';

		$this->load->library('excel');
		$object = new PHPExcel();
		foreach(range('A','L') as $columnID) {
			$object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}

		$styleArray = array(
			'font'  => array(
					'bold'  => true,
					'size'  => 13
			));

		$styleArray1 = array(
			'font'  => array(
					'bold'  => true,
					'size'  => 15
			));

		$styleArray2 = array(
			'font'  => array(
					'bold'  => true,
					'size'  => 12
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			),
			'borders' => array(
				'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
				)
			));

		$styleArray3 = array(
			'font'  => array(
				'size'  => 12
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000')
				)
		));

		$styleArray4 = array(
			'font'  => array(
				'size'  => 12
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			));

		$object->setActiveSheetIndex(0);
		$object->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray1);
		$object->getActiveSheet()->getStyle('A3:D3')->applyFromArray($styleArray);

		$object->getActiveSheet()->setCellValueByColumnAndRow(0, 1, $this->langs->import);

		$excel_column = 0;
		if ($category_id) {
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 3, $this->langs->category.":");
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 4, $category_id2);
			$excel_column++;
		}

		if ($product_id) {
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 3, $this->langs->product_name.":");
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 4, $product_name);
			$excel_column++;
		}

		if ($date_start) {
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 3, $this->langs->start_date.":");
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 4, $date_start);
			$excel_column++;
		}

		if ($date_end) {
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 3, $this->langs->end_date.":");
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 4, $date_end);
			$excel_column++;
		}

		if ($provider_id) {
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 3, $this->langs->salesman.":");
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 4, $salesman);
		}

		if($category_id || $product_id || $date_start || $date_end || $provider_id)
			$object->getActiveSheet()->getStyle('A4:E4')->applyFromArray($styleArray4);

		$excel_row = ($category_id || $product_id || $date_start || $date_end || $provider_id)?6:4;
		$excel_array = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
										'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $this->langs->code_of_product);
		$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $this->langs->product_name);
		$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $this->langs->date);
		$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $this->langs->salesman);
		$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $this->langs->measurement);
		$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $this->langs->count);
		$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $this->langs->price);
		$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $this->langs->summary);
		$object->getActiveSheet()->getStyle('A'.$excel_row.':'.$excel_array[7].$excel_row)->applyFromArray($styleArray2);

		$excel_row++;

		foreach($import_list as $row)
		{
			if($row->row_count):
				$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, '#'.$row->sku);
				$object->getActiveSheet()->mergeCells('A'.$excel_row.':A'.($excel_row + $row->row_count - 1));
				$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->p_name);
				$object->getActiveSheet()->mergeCells('B'.$excel_row.':B'.($excel_row + $row->row_count - 1));
			endif;

			$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->date_time);
			$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->provider);
			$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->measure);
			$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->count);
			$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->im_price." ₼");
			$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->count*$row->im_price." ₼");
			$object->getActiveSheet()->getStyle('A'.$excel_row.':'.$excel_array[7].$excel_row)->applyFromArray($styleArray3);
			$excel_row++;
		}

		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');

		ob_start();
		$object_writer->save("php://output");
		$xlsData = ob_get_contents();
		ob_end_clean();

		$response =  array(
				'op' => 'ok',
				'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
		);

		die(json_encode($response));
	}

	public function export_excel()
	{
		$date_start = $date_end = $product_id = $category_id = $provider_id = '';
		$get_data = $this->input->get();
		$filtered_get = $this->filter_data($get_data);

		if($this->input->get('category_id')){
			$category_id = $filtered_get['category_id'];
			$category_id2 = $this->reports_model->select_where_array('name', 'cat_id in ('.$filtered_get['category_id'].') and lang_id = '.$this->session->userdata('lang_id'), 'cats');
			foreach($category_id2 as $row)
				$category_id3[] = $row['name'];
			$category_id2 = implode(',', $category_id3);
		}
		if($this->input->get('product_id'))
			$product_id = $filtered_get['product_id'];
		if($this->input->get('date_start'))
			$date_start = $filtered_get['date_start'];
		if($this->input->get('date_end'))
			$date_end = $filtered_get['date_end'];
		if($this->input->get('provider_id'))
			$provider_id = (int) $filtered_get['provider_id'];

		$export_list = $this->reports_model->import_list_all($product_id, $date_start, $date_end, $category_id, $provider_id, $this->session->userdata('lang_id'), 1);
    $products = $this->reports_model->get_products($this->session->userdata('lang_id'));

		$pname_arr = $this->reports_model->select_where('title, description', array('p_id' => $product_id, 'lang_id' => $this->session->userdata('lang_id')), 'products');
		$product_name = $pname_arr?$pname_arr[0]->title.' - '.$pname_arr[0]->description:'';

		$buyer_arr = $this->reports_model->select_where('lastname', array('user_id' => $provider_id), 'site_users');
		$buyer = $buyer_arr?$buyer_arr[0]->lastname:'';

		$this->load->library('excel');
		$object = new PHPExcel();
		foreach(range('A','L') as $columnID) {
			$object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}

		$styleArray = array(
			'font'  => array(
					'bold'  => true,
					'size'  => 13
			));

		$styleArray1 = array(
			'font'  => array(
					'bold'  => true,
					'size'  => 15
			));

		$styleArray2 = array(
			'font'  => array(
					'bold'  => true,
					'size'  => 12
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			),
			'borders' => array(
				'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
				)
			));

		$styleArray3 = array(
			'font'  => array(
				'size'  => 12
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000')
				)
		));

		$styleArray4 = array(
			'font'  => array(
				'size'  => 12
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			));

		$object->setActiveSheetIndex(0);
		$object->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray1);
		$object->getActiveSheet()->getStyle('A3:D3')->applyFromArray($styleArray);

		$object->getActiveSheet()->setCellValueByColumnAndRow(0, 1, $this->langs->import);

		$excel_column = 0;
		if ($category_id) {
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 3, $this->langs->category.":");
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 4, $category_id2);
			$excel_column++;
		}

		if ($product_id) {
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 3, $this->langs->product_name.":");
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 4, $product_name);
			$excel_column++;
		}

		if ($date_start) {
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 3, $this->langs->start_date.":");
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 4, $date_start);
			$excel_column++;
		}

		if ($date_end) {
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 3, $this->langs->end_date.":");
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 4, $date_end);
			$excel_column++;
		}

		if ($provider_id) {
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 3, $this->langs->buyer.":");
			$object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, 4, $buyer);
		}

		if($category_id || $product_id || $date_start || $date_end || $provider_id)
			$object->getActiveSheet()->getStyle('A4:E4')->applyFromArray($styleArray4);

		$excel_row = ($category_id || $product_id || $date_start || $date_end || $provider_id)?6:4;
		$excel_array = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
										'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $this->langs->code_of_product);
		$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $this->langs->product_name);
		$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $this->langs->date);
		$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $this->langs->salesman);
		$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $this->langs->measurement);
		$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $this->langs->count);
		$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $this->langs->price);
		$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $this->langs->summary);
		$object->getActiveSheet()->getStyle('A'.$excel_row.':'.$excel_array[7].$excel_row)->applyFromArray($styleArray2);

		$excel_row++;

		foreach($export_list as $row)
		{
			if($row->row_count):
				$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, '#'.$row->sku);
				$object->getActiveSheet()->mergeCells('A'.$excel_row.':A'.($excel_row + $row->row_count - 1));
				$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->p_name);
				$object->getActiveSheet()->mergeCells('B'.$excel_row.':B'.($excel_row + $row->row_count - 1));
			endif;

			$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->date_time);
			$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->provider);
			$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->measure);
			$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->count);
			$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->ex_price." ₼");
			$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->count*$row->ex_price." ₼");
			$object->getActiveSheet()->getStyle('A'.$excel_row.':'.$excel_array[7].$excel_row)->applyFromArray($styleArray3);
			$excel_row++;
		}

		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');

		ob_start();
		$object_writer->save("php://output");
		$xlsData = ob_get_contents();
		ob_end_clean();

		$response =  array(
				'op' => 'ok',
				'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
		);

		die(json_encode($response));
	}

	public function import_report()
  {
		// $this->output->enable_profiler(true);
		$product_id = $start_date = $end_date = $salesman = '';
		$category_id = [];

		if($this->input->post())
		{
			$post = $this->input->post();
			$filtered_post = $this->filter_data($post);

			if($this->input->post('product_id'))
				$product_id = (int) $filtered_post['product_id'];

			if($this->input->post('start_date'))
				$start_date = date('Y-m-d H:m:s', (strtotime($filtered_post['start_date'])));

			if($this->input->post('end_date'))
				$end_date = date('Y-m-d H:m:s', (strtotime($filtered_post['end_date'])));

			if($this->input->post('category_id'))
				$category_id = $filtered_post['category_id'];

			if($this->input->post('salesman'))
				$salesman = $filtered_post['salesman'];
		}

		$category_id = implode(',', $category_id);

		$from=0;

		if($this->input->get('page'))
		{
			$get = $this->input->get();
			$filtered_get = $this->filter_data($get);
			$from = (int)$filtered_get['page'];
		}

		$count = 15;

		$data["import_list"] = $this->reports_model->import_list($from, $count, $product_id, $start_date, $end_date, $category_id, $salesman, $this->session->userdata('lang_id'), 0);

		$base_url = "/reports/import_report";
		$total = $this->reports_model->import_list_rows($product_id, $start_date, $end_date, $category_id, $salesman, 0);

		if($total->count >= 1)
			$data["pagination"] = $this->pagination($from, $count, $base_url, $total->count, 3, 4);

		$data['category_id'] = $category_id;
		$data['date_start'] = $start_date;
		$data['date_end'] = $end_date;
		$data['product_id'] = $product_id;
		$data['provider_id'] = $salesman;
		$pname_arr = $this->reports_model->select_where('title, description', array('p_id' => $product_id, 'lang_id' => $this->session->userdata('lang_id')), 'products');
		$data['product_name'] = ($pname_arr)?$pname_arr[0]->title.' - '.$pname_arr[0]->description:'';
    $data["products"] = $this->reports_model->get_products($this->session->userdata('lang_id'));
		$data["salesmen"] = $this->reports_model->select_function('id, fullname', 'salesmen');

    $this->home('reports/import_report', $data);
  }

	public function action_records()
  {
		$product_id = $start_date = $end_date = $action_name = '';
		$user_name = 0;
		$category_id = [];

		if($this->input->get())
		{
			$get = $this->input->get();
			$filtered_get = $this->filter_data($get);

			if($this->input->get('product_id'))
				$product_id = (int) $filtered_get['product_id'];

			if($this->input->get('start_date'))
				$start_date = date('Y-m-d H:m:s', (strtotime($filtered_get['start_date'])));

			if($this->input->get('end_date'))
				$end_date = date('Y-m-d H:m:s', (strtotime($filtered_get['end_date'])));

			if($this->input->get('category_id'))
				$category_id = $filtered_get['category_id'];

			if($this->input->get('user_name'))
				$user_name = (int) $filtered_get['user_name'];

			if($this->input->get('action_name'))
				$action_name = $filtered_get['action_name'];
		}

		$category_id = implode(',', $category_id);

		$from=0;

		if($this->input->get('page'))
		{
			$get = $this->input->get();
			$filtered_get = $this->filter_data($get);
			$from = (int)$filtered_get['page'];
		}

		$count = 15;

		$data["action_records"] = $this->reports_model->action_records($from, $count, $product_id, $start_date, $end_date, $category_id, $user_name, $action_name, $this->session->userdata('lang_id'));

		$base_url = "/reports/action_records";
		$total = $this->reports_model->action_records_rows($product_id, $start_date, $end_date, $category_id, $user_name, $action_name);

		if($total->count >= 1)
			$data["pagination"] = $this->pagination($from, $count, $base_url, $total->count, 3, 4);

		$data['category_id'] = $category_id;
		$data['date_start'] = $start_date;
		$data['date_end'] = $end_date;
		$data['product_id'] = $product_id;
		$data['user_name'] = $user_name;
		$data['action_name'] = $action_name;
		$pname_arr = $this->reports_model->select_where('title, description', array('p_id' => $product_id, 'lang_id' => $this->session->userdata('lang_id')), 'products');
		$data['product_name'] = ($pname_arr)?$pname_arr[0]->title.' - '.$pname_arr[0]->description:'';
    $data['products'] = $this->reports_model->get_products($this->session->userdata('lang_id'));
		$data['users'] = $this->reports_model->select_where('id, name', 'active=1 and deleted=0', 'users');

    $this->home('reports/action_records', $data);
  }

	public function export_report()
  {
		// $this->output->enable_profiler(true);
		$product_id = $start_date = $end_date = $buyer = '';
		$category_id = [];

		if($this->input->post())
		{
			$post = $this->input->post();
			$filtered_post = $this->filter_data($post);

			if($this->input->post('product_id'))
				$product_id = (int) $filtered_post['product_id'];

			if($this->input->post('start_date'))
				$start_date = date('Y-m-d H:m:s', (strtotime($filtered_post['start_date'])));

			if($this->input->post('end_date'))
				$end_date = date('Y-m-d H:m:s', (strtotime($filtered_post['end_date'])));

			if($this->input->post('category_id'))
				$category_id = $filtered_post['category_id'];

			if($this->input->post('buyer'))
				$buyer = $filtered_post['buyer'];
		}

		$category_id = implode(',', $category_id);

		$from=0;

		if($this->input->get('page'))
		{
			$get = $this->input->get();
			$filtered_get = $this->filter_data($get);
			$from = (int)$filtered_get['page'];
		}

		$count = 15;

		$data["export_list"] = $this->reports_model->import_list($from, $count, $product_id, $start_date, $end_date, $category_id, $buyer, $this->session->userdata('lang_id'), 1);

		$base_url = "/reports/export_report";
		$total = $this->reports_model->import_list_rows($product_id, $start_date, $end_date, $category_id, $buyer, 1);

		if($total->count >= 1)
			$data["pagination"] = $this->pagination($from, $count, $base_url, $total->count, 3, 4);

		$data['category_id'] = $category_id;
		$data['date_start'] = $start_date;
		$data['date_end'] = $end_date;
		$data['product_id'] = $product_id;
		$data['provider_id'] = $buyer;
		$pname_arr = $this->reports_model->select_where('title, description', array('p_id' => $product_id, 'lang_id' => $this->session->userdata('lang_id')), 'products');
		$data['product_name'] = ($pname_arr)?$pname_arr[0]->title.' - '.$pname_arr[0]->description:'';
    $data["products"] = $this->reports_model->get_products($this->session->userdata('lang_id'));
		$data["buyers"] = $this->reports_model->select_where('user_id, lastname', array('status' => 1), 'site_users');

    $this->home('reports/export_report', $data);
  }

	public function inventory()
	{
		$data["products"] = $this->reports_model->get_products($this->session->userdata('lang_id'));

		$this->home('reports/inventory', $data);
	}

	public function inventory_next()
	{
		$data = $p_id_arr = $count_arr = [];
		$p_id = '';

		if($this->input->post())
		{
			$post = $this->input->post();
			$filtered_post = $this->filter_data($post);

			$p_id_arr = $filtered_post['p_id2'];
			$count_arr = $filtered_post['count2'];

			$p_id = implode(',', $p_id_arr);

			$data['list'] = $this->reports_model->get_inventory($p_id, $this->session->userdata('lang_id'));
			$data['count_arr'] = $count_arr;
		}

		$this->home('reports/inventory_next', $data);
	}

	public function inventory_excel()
	{
		$sku = $product_name = $count = $availability = $difference = [];

		$sku = json_decode(stripslashes($this->input->post('sku')));
		$product_name = json_decode(stripslashes($this->input->post('product_name')));
		$count = json_decode(stripslashes($this->input->post('count')));
		$availability = json_decode(stripslashes($this->input->post('availability')));
		$difference = json_decode(stripslashes($this->input->post('difference')));

		$this->load->library('excel');
		$object = new PHPExcel();
		foreach(range('A','G') as $columnID) {
			$object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}

		$styleArray1 = array(
			'font'  => array(
					'bold'  => true,
					'size'  => 15
			));

		$styleArray2 = array(
			'font'  => array(
					'bold'  => true,
					'size'  => 12
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			),
			'borders' => array(
				'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
				)
			));

		$styleArray3 = array(
			'font'  => array(
				'size'  => 12
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000')
				)
		));

		$object->setActiveSheetIndex(0);
		$object->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray1);

		$object->getActiveSheet()->setCellValueByColumnAndRow(0, 1, $this->langs->inventory);

		$object->getActiveSheet()->setCellValueByColumnAndRow(0, 3, $this->langs->code_of_product);
		$object->getActiveSheet()->setCellValueByColumnAndRow(1, 3, $this->langs->product_name);
		$object->getActiveSheet()->setCellValueByColumnAndRow(2, 3, $this->langs->count);
		$object->getActiveSheet()->setCellValueByColumnAndRow(3, 3, $this->langs->availability);
		$object->getActiveSheet()->setCellValueByColumnAndRow(4, 3, $this->langs->difference);
		$object->getActiveSheet()->getStyle('A3:E3')->applyFromArray($styleArray2);

		$excel_row=4;

		for($i=0; $i<count($sku); $i++)
		{
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $sku[$i]);
			$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $product_name[$i]);
			$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $count[$i]);
			$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $availability[$i]);
			$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $difference[$i]);
			$object->getActiveSheet()->getStyle('A'.$excel_row.':E'.$excel_row)->applyFromArray($styleArray3);
			$excel_row++;
		}

		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');

		ob_start();
		$object_writer->save("php://output");
		$xlsData = ob_get_contents();
		ob_end_clean();

		$response =  array(
				'op' => 'ok',
				'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
		);

		die(json_encode($response));
	}
}
