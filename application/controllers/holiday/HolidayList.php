<?php

/**
 * HolidayListController
 * @author masahide_kinutani
 *
 */
class HolidayList extends MY_Controller {
	
	/**
	 * Index
	 */
	public function index() {
		
		$this->load->model('holiday/HolidayListModel', 'model');
		$this->load->library('dao/HolidayDao');
		
		$this->set('list', $this->model->get_list());
		$this->set('list_col', $this->model->get_list_col());
		$this->set('link', $this->model->get_link_list());
		$this->set('class_path', 'holiday/Holiday');
		
		$this->view('holiday/holiday_list');
	}
	
	/**
	 * 検索
	 */
	public function search() {
		
		$search = $this->get_attribute();
		
		$this->load->model('holiday/HolidayListModel', 'model');
		$this->load->library('dao/HolidayDao');
		
		$this->set('list', $this->model->get_list($search));
		$this->set('list_col', $this->model->get_list_col());
		$this->set('link', $this->model->get_link_list());
		$this->set('class_path', 'holiday/Holiday');
		
		$this->view('holiday/holiday_list');
	}
	
	/**
	 * 一覧のExcel出力
	 */
	public function output() {
		
		$this->load->model('holiday/HolidayListModel', 'model');
		$this->load->library('dao/HolidayDao');
		
		$list = $this->model->get_list();
		$list_col = $this->model->get_list_col();
		
		$this->load->model('common/ListOutputModel', 'list');
		
		$this->list->output('祝祭日一覧', $list, $list_col);
	}
}
?>