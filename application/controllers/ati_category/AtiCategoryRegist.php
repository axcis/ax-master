<?php

/**
 * AtiCategoryRegistController
 * @author gozuchi
 *
 */
class AtiCategoryRegist extends MY_Controller {
	
	public function regist_input() {
		
		$this->set('action', 'regist');
		$this->set('class_path', 'ati_category/AtiCategory');
		$this->view('ati_category/ati_category_input');
	}
	
	/**
	 * 新規登録
	 */
	public function regist() {
		
		$this->load->model('ati_category/AtiCategoryRegistModel', 'model');
		$this->load->library('dao/AtiCategoryDao');
		
		$input = $this->get_attribute();
		
		$msgs = $this->model->validation($input);
		
		if ($msgs != null) {
			$this->set_err_info($msgs);
			$this->view('ati_category/ati_category_input');
			return;
		}
		
		$this->model->db_regist($input);
		
		$this->redirect_js(base_url(). 'ati_category/AtiCategoryList');
	}
	
	public function modify_input($id) {
		
		$this->load->model('ati_category/AtiCategoryRegistModel', 'model');
		$this->load->library('dao/AtiCategoryDao');
		
		$this->set_attribute($this->model->get_ati_category_info($id));
		
		$this->set('action', 'modify');
		$this->set('class_path', 'ati_category/AtiCategory');
		$this->view('ati_category/ati_category_input');
	}
	
	/**
	 * 更新
	 */
	public function modify() {
		
		$this->load->model('ati_category/AtiCategoryRegistModel', 'model');
		$this->load->library('dao/AtiCategoryDao');
		
		$input = $this->get_attribute();
		
		$msgs = $this->model->validation($input);
		
		if ($msgs != null) {
			$this->set_err_info($msgs);
			$this->view('ati_category/ati_category_input');
			return;
		}
		
		$this->model->db_modify($input);
		
		$this->redirect_js(base_url(). 'ati_category/AtiCategoryList');
	}
}
?>