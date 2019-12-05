<?php

/**
 * PasswordResetController
 * @author takanori_gozu
 *
 */
class PasswordReset extends MY_Controller {
	
	/**
	 * Index
	 */
	public function index() {
		
		$this->load->model('password/PasswordResetModel', 'model');
		$this->load->library('dao/EmployeeDao');
		
		$this->set('action', 'modify');
		
		$this->set('employee_map', $this->model->get_employee_map());
		
		$this->view('password/password_reset_input');
	}
	
	/**
	 * リセット
	 */
	public function modify() {
		
		$this->load->model('password/PasswordResetModel', 'model');
		$this->load->library('dao/EmployeeDao');
		
		$input = $this->get_attribute();
		
		$msgs = $this->model->validation($input);
		
		if ($msgs != null) {
			$this->set_err_info($msgs);
			$this->set('employee_map', $this->model->get_employee_map());
			$this->view('password/password_reset_input');
			return;
		}
		
		$this->model->db_modify($input);
		
		$this->redirect_js(base_url(). 'TopPage');
	}
}
?>