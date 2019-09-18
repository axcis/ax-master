<?php

/**
 * EmployeeRegistController
 * @author takanori_gozu
 *
 */
class EmployeeRegist extends MY_Controller {
	
	public function regist_input() {
		
		$this->load->model('employee/EmployeeRegistModel', 'model');
		$this->load->library('dao/DivisionDao');
		
		$this->set('action', 'regist');
		$this->set('division_map', $this->model->get_division_map());
		$this->set('user_level_map', $this->model->get_user_level_map());
		$this->set('class_path', 'employee/Employee');
		
		$this->view('employee/employee_input');
	}
	
	/**
	 * 新規登録
	 */
	public function regist() {
		
		$input = $this->get_attribute();
		
		$this->load->model('employee/EmployeeRegistModel', 'model');
		$this->load->library('dao/EmployeeDao');
		$this->load->library('dao/DivisionDao');
		
		$msgs = $this->model->validation($input);
		
		if ($msgs != null) {
			$this->set_err_info($msgs);
			$this->set('division_map', $this->model->get_division_map());
			$this->set('user_level_map', $this->model->get_user_level_map());
			$this->view('employee/employee_input');
			return;
		}
		
		$this->model->db_regist($input);
		
		$this->redirect_js(base_url(). 'employee/EmployeeList');
	}
	
	public function modify_input($id) {
		
		$this->load->model('employee/EmployeeRegistModel', 'model');
		$this->load->library('dao/EmployeeDao');
		$this->load->library('dao/DivisionDao');
		
		$info = $this->model->get_employee_info($id);
		
		$this->set_attribute($info);
		
		$this->set('action', 'modify');
		$this->set('division_map', $this->model->get_division_map());
		$this->set('user_level_map', $this->model->get_user_level_map());
		//メールアドレス再セット(@より前を表示)
		$this->set('email_address', substr($info['email_address'], 0, strpos($info['email_address'], '@')));
		if ($info['retirement'] == '1') $this->set('retirement_checked', array(1));
		$this->set('class_path', 'employee/Employee');
		
		$this->view('employee/employee_input');
	}
	
	/**
	 * 更新
	 */
	public function modify() {
		
		$input = $this->get_attribute();
		
		$this->load->model('employee/EmployeeRegistModel', 'model');
		$this->load->library('dao/EmployeeDao');
		$this->load->library('dao/DivisionDao');
		
		$msgs = $this->model->validation($input);
		
		if ($msgs != null) {
			$this->set_err_info($msgs);
			$this->set('division_map', $this->model->get_division_map());
			$this->set('user_level_map', $this->model->get_user_level_map());
			$this->view('employee/employee_input');
			return;
		}
		
		$this->model->db_modify($input);
		
		$this->redirect_js(base_url(). 'employee/EmployeeList');
	}
}
?>