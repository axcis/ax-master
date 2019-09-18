<?php

/**
 * DocumentCategoryListController
 * @author takanori_gozu
 *
 */
class DocumentCategoryList extends MY_Controller {
	
	/**
	 * Index
	 */
	public function index() {
		
		$this->load->model('document_category/DocumentCategoryListModel', 'model');
		$this->load->library('dao/DocumentCategoryDao');
		
		$this->set('list', $this->model->get_list());
		$this->set('list_col', $this->model->get_list_col());
		$this->set('link', $this->model->get_link_list());
		$this->set('class_path', 'document_category/DocumentCategory');
		$this->set('no_search', '1');
		
		$this->view('document_category/document_category_list');
	}
	
	/**
	 * 一覧のExcel出力
	 */
	public function output() {
		
		$this->load->model('document_category/DocumentCategoryListModel', 'model');
		$this->load->library('dao/DocumentCategoryDao');
		
		$list = $this->model->get_list();
		$list_col = $this->model->get_list_col();
		
		$this->load->model('common/ListOutputModel', 'list');
		
		$this->list->output('社内文書カテゴリ一覧', $list, $list_col);
	}
}
?>