<?php

/**
 * SecurityQuestionListController
 * @author takanori_gozu
 *
 */
class SecurityQuestionList extends MY_Controller {
	
	/**
	 * Index
	 */
	public function index() {
		
		$this->load->model('training/TrainingQuestionListModel', 'model');
		$this->load->library('dao/TrainingQuestionDao');
		
		$this->set('list', $this->model->get_list(TrainingQuestionDao::TRAINING_TYPE_SECURITY));
		$this->set('list_col', $this->model->get_list_col());
		$this->set('link', $this->model->get_link_list('security_question/SecurityQuestion'));
		$this->set('class_path', 'security_question/SecurityQuestion');
		$this->set('no_search', '1');
		
		$this->view('security_question/security_question_list');
	}
	
	/**
	 * 一覧のExcel出力
	 */
	public function output() {
		
		$this->load->model('training/TrainingQuestionListModel', 'model');
		$this->load->library('dao/TrainingQuestionDao');
		
		$list = $this->model->get_list(TrainingQuestionDao::TRAINING_TYPE_SECURITY);
		$list_col = $this->model->get_list_col();
		
		$this->load->model('common/ListOutputModel', 'list');
		
		$this->list->output('セキュリティ問題一覧', $list, $list_col);
	}
}
?>