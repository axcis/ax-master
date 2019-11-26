<?php

/**
 * TrainingQuestionRegistController
 * @author takanori_gozu
 *
 */
class TrainingQuestionRegist extends MY_Controller {
	
	public function regist_input() {
		
		$this->load->model('training_question/TrainingQuestionRegistModel', 'model');
		$this->load->library('dao/TrainingCategoryDao');
		
		$this->set('training_category_map', $this->model->get_training_category_map());
		
		$this->set('action', 'regist');
		$this->set('class_path', 'training_question/TrainingQuestion');
		
		$this->view('training_question/training_question_input');
	}
	
	/**
	 * 新規登録
	 */
	public function regist() {
		
		$this->load->model('training_question/TrainingQuestionRegistModel', 'model');
		$this->load->library('dao/TrainingQuestionDao');
		
		$input = $this->get_attribute();
		
		$msgs = $this->model->validation($input);
		
		if ($msgs != null) {
			$this->set_err_info($msgs);
			$this->load->library('dao/TrainingCategoryDao');
			$this->set('training_category_map', $this->model->get_training_category_map());
			$this->view('training_question/training_question_input');
			return;
		}
		
		$this->model->db_regist($input);
		
		$this->redirect_js(base_url(). 'training_question/TrainingQuestionList');
	}
	
	public function modify_input($type_id) {
		
		$this->load->model('training_question/TrainingQuestionRegistModel', 'model');
		$this->load->library('dao/TrainingQuestionDao');
		$this->load->library('dao/TrainingCategoryDao');
		
		$this->set('training_category_map', $this->model->get_training_category_map());
		
		$this->set_attribute($this->model->get_training_question_info($type_id));
		
		$this->set('action', 'modify');
		$this->set('class_path', 'training_question/TrainingQuestion');
		
		$this->view('training_question/training_question_input');
	}
	
	/**
	 * 更新
	 */
	public function modify() {
		
		$this->load->model('training_question/TrainingQuestionRegistModel', 'model');
		$this->load->library('dao/TrainingQuestionDao');
		
		$input = $this->get_attribute();
		
		$msgs = $this->model->validation($input);
		
		if ($msgs != null) {
			$this->set_err_info($msgs);
			$this->load->library('dao/TrainingCategoryDao');
			$this->set('training_category_map', $this->model->get_training_category_map());
			$this->view('training_question/training_question_input');
			return;
		}
		
		$this->model->db_modify($input);
		
		$this->redirect_js(base_url(). 'training_question/TrainingQuestionList');
	}
}
?>