<?php

/**
 * TrainingQuetionListController
 * @author takanori_gozu
 *
 */
class TrainingQuestionList extends MY_Controller {
	
	/**
	 * Index
	 */
	public function index() {
		
		$this->load->model('training_question/TrainingQuestionListModel', 'model');
		$this->load->library('dao/TrainingCategoryDao');
		$this->load->library('dao/TrainingQuestionDao');
		
		$this->set('list', $this->model->get_list());
		$this->set('list_col', $this->model->get_list_col());
		$this->set('link', $this->model->get_link_list());
		$this->set('class_path', 'training_question/TrainingQuestion');
		
		$this->set('training_category_map', $this->model->get_training_category_map());
		
		$this->view('training_question/training_question_list');
	}
	
	/**
	 * 検索
	 */
	public function search() {
		
		$this->load->model('training_question/TrainingQuestionListModel', 'model');
		$this->load->library('dao/TrainingCategoryDao');
		$this->load->library('dao/TrainingQuestionDao');
		
		$search = $this->get_attribute();
		
		$this->set('list', $this->model->get_list($search));
		$this->set('list_col', $this->model->get_list_col());
		$this->set('link', $this->model->get_link_list());
		$this->set('class_path', 'training_question/TrainingQuestion');
		
		$this->set('training_category_map', $this->model->get_training_category_map());
		
		$this->view('training_question/training_question_list');
	}
	
	/**
	 * 一覧のExcel出力
	 */
	public function output() {
		
		$this->load->model('training_question/TrainingQuestionListModel', 'model');
		$this->load->library('dao/TrainingCategoryDao');
		$this->load->library('dao/TrainingQuestionDao');
		
		$list = $this->model->get_list();
		$list_col = $this->model->get_list_col();
		
		//training_typeをlistから除外
		$this->model->unset_list($list);
		
		$this->load->model('common/ListOutputModel', 'list');
		
		$this->list->output('社内研修問題一覧', $list, $list_col);
	}
}
?>