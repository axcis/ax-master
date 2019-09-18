<?php

/**
 * DocumentCategoryRegistController
 * @author takanori_gozu
 *
 */
class DocumentCategoryRegist extends MY_Controller {
	
	public function regist_input() {
		
		$this->set('action', 'regist');
		$this->set('class_path', 'document_category/DocumentCategory');
		$this->view('document_category/document_category_input');
	}
	
	/**
	 * 新規登録
	 */
	public function regist() {
		
		$input = $this->get_attribute();
		
		$this->load->model('document_category/DocumentCategoryRegistModel', 'model');
		$this->load->library('dao/DocumentCategoryDao');
		
		$msgs = $this->model->validation($input);
		
		if ($msgs != null) {
			$this->set_err_info($msgs);
			$this->view('document_category/document_category_input');
			return;
		}
		
		$this->model->db_regist($input);
		
		$this->redirect_js(base_url(). 'document_category/DocumentCategoryList');
	}
	
	public function modify_input($id) {
		
		$this->load->model('document_category/DocumentCategoryRegistModel', 'model');
		$this->load->library('dao/DocumentCategoryDao');
		
		$info = $this->model->get_document_category_info($id);
		
		$this->set_attribute($info);
		
		$this->set('action', 'modify');
		$this->set('class_path', 'document_category/DocumentCategory');
		$this->view('document_category/document_category_input');
	}
	
	/**
	 * 更新
	 */
	public function modify() {
		
		$input = $this->get_attribute();
		
		$this->load->model('document_category/DocumentCategoryRegistModel', 'model');
		$this->load->library('dao/DocumentCategoryDao');
		
		$msgs = $this->model->validation($input);
		
		if ($msgs != null) {
			$this->set_err_info($msgs);
			$this->view('document_category/document_category_input');
			return;
		}
		
		$this->model->db_modify($input);
		
		$this->redirect_js(base_url(). 'document_category/DocumentCategoryList');
	}
}
?>