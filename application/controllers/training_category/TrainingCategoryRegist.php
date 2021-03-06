<?php

/**
 * TrainingCategoryRegistController
 * @author takanori_gozu
 *
 */
class TrainingCategoryRegist extends MY_Controller {
	
	public function regist_input() {
		
		$this->set('action', 'regist');
		$this->set('class_path', 'training_category/TrainingCategory');
		$this->view('training_category/training_category_input');
	}
	
	/**
	 * 新規登録
	 */
	public function regist() {
		
		$this->load->model('training_category/TrainingCategoryRegistModel', 'model');
		$this->load->library('dao/TrainingCategoryDao');
		
		$input = $this->get_attribute();
		
		$msgs = $this->model->validation($input);
		
		if ($msgs != null) {
			$this->set_err_info($msgs);
			$this->view('training_category/training_category_input');
			return;
		}
		
		$this->model->db_regist($input);
		
		$this->redirect_js(base_url(). 'training_category/TrainingCategoryList');
	}
	
	public function modify_input($id) {
		
		$this->load->model('training_category/TrainingCategoryRegistModel', 'model');
		$this->load->library('dao/TrainingCategoryDao');
		
		$info = $this->model->get_training_category_info($id);
		
		$this->set_attribute($info);
		
		$this->set('text_file_name', substr($info['text_file_name'], 0, strpos($info['text_file_name'], '.')));
		$this->set('dl_text_name', substr($info['dl_text_name'], 0, strpos($info['dl_text_name'], '.')));
		
		$this->set('action', 'modify');
		$this->set('class_path', 'training_category/TrainingCategory');
		$this->view('training_category/training_category_input');
	}
	
	/**
	 * 更新
	 */
	public function modify() {
		
		$this->load->model('training_category/TrainingCategoryRegistModel', 'model');
		$this->load->library('dao/TrainingCategoryDao');
		
		$input = $this->get_attribute();
		
		$msgs = $this->model->validation($input);
		
		if ($msgs != null) {
			$this->set_err_info($msgs);
			$this->view('training_category/training_category_input');
			return;
		}
		
		$this->model->db_modify($input);
		
		$this->redirect_js(base_url(). 'training_category/TrainingCategoryList');
	}
}
?>