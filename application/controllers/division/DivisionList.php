<?php

/**
 * DivisionListController
 * @author takanori_gozu
 *
 */
class DivisionList extends MY_Controller {
	
	/**
	 * Index
	 */
	public function index() {
		
		$this->load->model('division/DivisionListModel', 'model');
		$this->load->library('dao/DivisionDao');
		
		$this->set('list', $this->model->get_list());
		$this->set('list_col', $this->model->get_list_col());
		$this->set('link', $this->model->get_link_list());
		$this->set('class_path', 'division/Division');
		$this->set('no_search', '1');
		
		$this->view('division/division_list');
	}
	
	/**
	 * 一覧のExcel出力
	 */
	public function output() {
		
		$this->load->model('division/DivisionListModel', 'model');
		$this->load->library('dao/DivisionDao');
		
		$list = $this->model->get_list();
		$list_col = $this->model->get_list_col();
		
		$this->load->model('common/ListOutputModel', 'list');
		
		$this->list->output('部署一覧', $list, $list_col);
	}
}
?>