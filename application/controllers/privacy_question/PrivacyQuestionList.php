<?php

/**
 * PrivacyQuestionListController
 * @author takanori_gozu
 *
 */
class PrivacyQuestionList extends MY_Controller {
	
	/**
	 * Index
	 */
	public function index() {
		
		$this->load->model('training/TrainingQuestionListModel', 'model');
		$this->load->library('dao/TrainingQuestionDao');
		
		$this->set('list', $this->model->get_list(TrainingQuestionDao::TRAINING_TYPE_PRIVACY));
		$this->set('list_col', $this->model->get_list_col());
		$this->set('link', $this->model->get_link_list('privacy_question/PrivacyQuestion'));
		$this->set('class_path', 'privacy_question/PrivacyQuestion');
		$this->set('no_search', '1');
		
		$this->view('privacy_question/privacy_question_list');
	}
	
	/**
	 * 一覧のExcel出力
	 */
	public function output() {
		
		$this->load->model('training/TrainingQuestionListModel', 'model');
		$this->load->library('dao/TrainingQuestionDao');
		
		$list = $this->model->get_list(TrainingQuestionDao::TRAINING_TYPE_PRIVACY);
		$list_col = $this->model->get_list_col();
		
		$this->load->model('common/ListOutputModel', 'list');
		
		$this->list->output('Pマーク問題一覧', $list, $list_col);
	}
}
?>