<?php

/**
 * TopPageController
 * @author takanori_gozu
 *
 */
class TopPage extends MY_Controller {
	
	/**
	 * Index
	 */
	public function index() {
		
		$this->load->model('top/TopPageModel', 'model');
		
		//コンテンツ情報を取得
		$list = $this->model->get_contents_list();
		
		$this->set('contents_list', $list);
		
		$this->view('top/top_page');
	}
}
?>