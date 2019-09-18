<?php

/**
 * HolidayRegistController
 * @author masahide_kinutani
 *
 */
class HolidayRegist extends MY_Controller {
	
	public function regist_input() {
		
		$this->set('action', 'regist');
		$this->set('class_path', 'holiday/Holiday');
		$this->view('holiday/holiday_input');
	}
	
	/**
	 * 新規登録
	 */
	public function regist() {
		
		$input = $this->get_attribute();
		
		$this->load->model('holiday/HolidayRegistModel', 'model');
		$this->load->library('dao/HolidayDao');
		
		$msgs = $this->model->validation($input);
		
		if ($msgs != null) {
			$this->set_err_info($msgs);
			$this->view('holiday/holiday_input');
			return;
		}
		
		$this->model->db_regist($input);
		
		$this->redirect_js(base_url(). 'holiday/HolidayList');
	}
	
	public function modify_input($id) {
		
		$this->load->model('holiday/HolidayRegistModel', 'model');
		$this->load->library('dao/HolidayDao');
		
		$info = $this->model->get_holiday_info($id);
		
		$this->set_attribute($info);
		
		$this->set('id', $info['holiday_date']);
		$this->set('action', 'modify');
		$this->set('class_path', 'holiday/Holiday');
		$this->view('holiday/holiday_input');
	}
	
	/**
	 * 更新
	 */
	public function modify() {
		
		$input = $this->get_attribute();
		
		$this->load->model('holiday/HolidayRegistModel', 'model');
		$this->load->library('dao/HolidayDao');
		
		$msgs = $this->model->validation($input);
		
		if ($msgs != null) {
			$this->set('holiday_date', $input['id']);
			$this->set_err_info($msgs);
			$this->view('holiday/holiday_input');
			return;
		}
		
		$this->model->db_modify($input);
		
		$this->redirect_js(base_url(). 'holiday/HolidayList');
	}
}
?>