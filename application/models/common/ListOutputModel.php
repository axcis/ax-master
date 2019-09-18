<?php

/**
 * ListOutputModel
 * 一覧出力の共通モデル
 * @author takanori_gozu
 *
 */
class ListOutputModel extends MY_Model {
	
	/**
	 * 出力
	 */
	public function output($title, $list, $col) {
		
		$this->load->model('common/PHPExcelModel', 'excel');
		
		$this->excel_init();
		
		//タイトル
		$this->excel->set_cell_value_A1('A1', $title);
		
		//一覧の項目名
		$last_col = $this->set_list_col($col);
		
		//一覧の値
		$last_row = $this->set_list_val($list);
		
		//体裁
		$this->format_arrange($last_col, $last_row);
		
		$this->excel->save($title. '.xlsx');
	}
	
	/**
	 * 初期化
	 */
	private function excel_init() {
		
		$this->excel->init();
		$this->excel->set_sheet();
		//ページ設定(A4横向き)
		$this->excel->set_pagesize_A4();
		$this->excel->set_page_orientation();
		$this->excel->set_default_font('Meiryo UI');
		$this->excel->set_margin(0.5, 0.5, 0.8, 0, 0.5, 0.5);
		$this->excel->set_title('一覧');
	}
	
	/**
	 * 一覧の項目名
	 */
	private function set_list_col($col) {
		
		$col_no = 0;
		
		foreach ($col as $row) {
			
			$width = $row['width'] / 10; //セルの幅は設定されている値の10分の1
			$value = $row['value']; //項目名
			
			$this->excel->set_cell_value_R1C1($col_no, 3, $value);
			$col_name = $this->excel->get_col_name($col_no); //列インデックスを列番号に変換
			$this->excel->set_column_width($col_name, $width);
			$this->excel->set_color($col_name. 3, 'dbdbdb');
			
			$col_no++;
		}
		
		return $col_no - 1;
	}
	
	/**
	 * 一覧の値
	 */
	private function set_list_val($list) {
		
		$row_no = 4;
		
		foreach ($list as $row) {
			$col_no = 1;
			foreach ($row as $key => $value) {
				$this->excel->set_cell_value_R1C1($col_no, $row_no, $value);
				$col_no++;
			}
			$row_no++;
		}
		
		return $row_no - 1;
	}
	
	/**
	 * 体裁調整
	 */
	private function format_arrange($last_col, $last_row) {
		
		$this->excel->set_font_size('A1', 14);
		
		$col_name = $this->excel->get_col_name($last_col);
		
		$this->excel->set_border('A3:'.$col_name. $last_row);
		$this->excel->set_wrap_text('A4:'.$col_name. $last_row); //データ部分のみ折り返し表示
		$this->excel->set_vertical_align('A4:'.$col_name. $last_row);
	}
}
?>