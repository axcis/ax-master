<?php

/**
 * EmployeeListController
 * @author takanori_gozu
 *
 */
class EmployeeList extends MY_Controller {
	
	/**
	 * Index
	 */
	public function index() {
		
		$this->load->model('employee/EmployeeListModel', 'model');
		$this->load->library('dao/EmployeeDao');
		$this->load->library('dao/DivisionDao');
		
		$this->set('list', $this->model->get_list());
		$this->set('list_col', $this->model->get_list_col());
		$this->set('link', $this->model->get_link_list());
		$this->set('class_path', 'employee/Employee');
		
		$this->set('division_map', $this->model->get_division_map());
		
		$this->view('employee/employee_list');
	}
	
	/**
	 * 検索
	 */
	public function search() {
		
		$search = $this->get_attribute();
		
		$this->load->model('employee/EmployeeListModel', 'model');
		$this->load->library('dao/EmployeeDao');
		$this->load->library('dao/DivisionDao');
		
		$this->set('list', $this->model->get_list($search));
		$this->set('list_col', $this->model->get_list_col());
		$this->set('link', $this->model->get_link_list());
		$this->set('class_path', 'employee/Employee');
		
		//チェックボックス
		if (isset($search['retirement_show']) && $search['retirement_show'] != '') {
			$this->set('retirement_show_checked', array(1));
		}
		
		$this->set('division_map', $this->model->get_division_map());
		
		$this->view('employee/employee_list');
	}
	
	/**
	 * 一覧のExcel出力
	 */
	public function output() {
		
		$this->load->model('employee/EmployeeListModel', 'model');
		$this->load->library('dao/EmployeeDao');
		$this->load->library('dao/DivisionDao');
		
		$list = $this->model->get_list();
		$list_col = $this->model->get_list_col();
		
		$this->load->model('common/ListOutputModel', 'list');
		
		$this->list->output('社員一覧', $list, $list_col);
	}
}
?>