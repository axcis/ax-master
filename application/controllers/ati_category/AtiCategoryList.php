<?php

/**
 * AtiCategoryListController
 * @author takanori_gozu
 *
 */
class AtiCategoryList extends MY_Controller {
	
	/**
	 * Index
	 */
	public function index() {
		
		$this->load->model('ati_category/AtiCategoryListModel', 'model');
		$this->load->library('dao/AtiCategoryDao');
		
		$this->set('list', $this->model->get_list());
		$this->set('list_col', $this->model->get_list_col());
		$this->set('link', $this->model->get_link_list());
		$this->set('class_path', 'ati_category/AtiCategory');
		
		$this->set('no_search', '1');
		
		$this->view('ati_category/ati_category_list');
	}
	
	/**
	 * 出力
	 */
	public function output() {
		
		$this->load->model('ati_category/AtiCategoryListModel', 'model');
		$this->load->library('dao/AtiCategoryDao');
		
		$list = $this->model->get_list();
		$list_col = $this->model->get_list_col();
		
		$this->load->model('common/ListOutputModel', 'list');
		
		$this->list->output('Eラーニングカテゴリ一覧', $list, $list_col);
	}
}
?>