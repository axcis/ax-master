<?php

/**
 * TrainingCategoryListController
 * @author takanori_gozu
 *
 */
class TrainingCategoryList extends MY_Controller {
	
	/**
	 * Index
	 */
	public function index() {
		
		$this->load->model('training_category/TrainingCategoryListModel', 'model');
		$this->load->library('dao/TrainingCategoryDao');
		
		$this->set('list', $this->model->get_list());
		$this->set('list_col', $this->model->get_list_col());
		$this->set('link', $this->model->get_link_list());
		$this->set('class_path', 'training_category/TrainingCategory');
		
		$this->set('no_search', '1');
		
		$this->view('training_category/training_category_list');
	}
	
	/**
	 * 一覧のExcel出力
	 */
	public function output() {
		
		$this->load->model('training_category/TrainingCategoryListModel', 'model');
		$this->load->library('dao/TrainingCategoryDao');
		
		$list = $this->model->get_list();
		$list_col = $this->model->get_list_col();
		
		$this->load->model('common/ListOutputModel', 'list');
		
		$this->list->output('社内研修カテゴリ一覧', $list, $list_col);
	}
}
?>