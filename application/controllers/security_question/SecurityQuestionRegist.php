<?php

/**
 * SecurityQuestionRegistController
 * @author takanori_gozu
 *
 */
class SecurityQuestionRegist extends MY_Controller {
	
	public function regist_input() {
		
		$this->set('action', 'regist');
		$this->set('class_path', 'security_question/SecurityQuestion');
		$this->view('security_question/security_question_input');
	}
	
	/**
	 * 新規登録
	 */
	public function regist() {
		
		$input = $this->get_attribute();
		
		$this->load->model('training/TrainingQuestionRegistModel', 'model');
		$this->load->library('dao/TrainingQuestionDao');
		
		$msgs = $this->model->validation($input, TrainingQuestionDao::TRAINING_TYPE_SECURITY);
		
		if ($msgs != null) {
			$this->set_err_info($msgs);
			$this->view('security_question/security_question_input');
			return;
		}
		
		$this->model->db_regist($input, TrainingQuestionDao::TRAINING_TYPE_SECURITY);
		
		$this->redirect_js(base_url(). 'security_question/SecurityQuestionList');
	}
	
	public function modify_input($id) {
		
		$this->load->model('training/TrainingQuestionRegistModel', 'model');
		$this->load->library('dao/TrainingQuestionDao');
		
		$this->set_attribute($this->model->get_training_question_info($id, TrainingQuestionDao::TRAINING_TYPE_SECURITY));
		
		$this->set('action', 'modify');
		$this->set('class_path', 'security_question/SecurityQuestion');
		$this->view('security_question/security_question_input');
	}
	
	/**
	 * 更新
	 */
	public function modify() {
		
		$input = $this->get_attribute();
		
		$this->load->model('training/TrainingQuestionRegistModel', 'model');
		$this->load->library('dao/TrainingQuestionDao');
		
		$msgs = $this->model->validation($input, TrainingQuestionDao::TRAINING_TYPE_SECURITY);
		
		if ($msgs != null) {
			$this->set_err_info($msgs);
			$this->view('security_question/security_question_input');
			return;
		}
		
		$this->model->db_modify($input, TrainingQuestionDao::TRAINING_TYPE_SECURITY);
		
		$this->redirect_js(base_url(). 'security_question/SecurityQuestionList');
	}
}
?>