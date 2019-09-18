<?php

/**
 * DivisionRegistController
 * @author takanori_gozu
 *
 */
class DivisionRegist extends MY_Controller {
	
	public function regist_input() {
		
		$this->set('action', 'regist');
		$this->set('class_path', 'division/Division');
		$this->view('division/division_input');
	}
	
	/**
	 * 新規登録
	 */
	public function regist() {
		
		$input = $this->get_attribute();
		
		$this->load->model('division/DivisionRegistModel', 'model');
		$this->load->library('dao/DivisionDao');
		
		$msgs = $this->model->validation($input);
		
		if ($msgs != null) {
			$this->set_err_info($msgs);
			$this->view('division/division_input');
			return;
		}
		
		$this->model->db_regist($input);
		
		$this->redirect_js(base_url(). 'division/DivisionList');
	}
	
	public function modify_input($id) {
		
		$this->load->model('division/DivisionRegistModel', 'model');
		$this->load->library('dao/DivisionDao');
		
		$this->set_attribute($this->model->get_division_info($id));
		
		$this->set('action', 'modify');
		$this->set('class_path', 'division/Division');
		$this->view('division/division_input');
	}
	
	/**
	 * 更新
	 */
	public function modify() {
		
		$input = $this->get_attribute();
		
		$this->load->model('division/DivisionRegistModel', 'model');
		$this->load->library('dao/DivisionDao');
		
		$msgs = $this->model->validation($input);
		
		if ($msgs != null) {
			$this->set_err_info($msgs);
			$this->view('division/division_input');
			return;
		}
		
		$this->model->db_modify($input);
		
		$this->redirect_js(base_url(). 'division/DivisionList');
	}
}
?>