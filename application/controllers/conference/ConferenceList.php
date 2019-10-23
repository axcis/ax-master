<?php

/**
 * ConferenceListController
 * @author yusuke_hoshino
 *
 */
class ConferenceList extends MY_Controller {
	/**
	 * Index
	 */
	public function index() {
		
		$this->load->model('conference/ConferenceListModel', 'model');
		$this->load->library('dao/ConferenceDao');
		
		$this->set('list', $this->model->get_list());
		$this->set('list_col', $this->model->get_list_col());
		$this->set('link', $this->model->get_link_list());
		$this->set('class_path', 'conference/Conference');
		$this->set('no_search', '1');
		
		$this->view('conference/conference_list');
	}
	/**
	 * 一覧のExcel出力
	 */
	public function output() {
		
		$this->load->model('conference/ConferenceListModel', 'model');
		$this->load->library('dao/ConferenceDao');
		
		$list = $this->model->get_list();
		$list_col = $this->model->get_list_col();
		$this->load->model('common/ListOutputModel', 'list');
		
		$this->list->output('会議室一覧', $list, $list_col);
	}
}
?>