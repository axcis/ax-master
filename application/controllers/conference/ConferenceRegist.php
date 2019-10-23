<?php

/**
 * ConferenceRegistController
 * @author yusuke_hoshino
 *
 */
class ConferenceRegist extends MY_Controller {
	
	public function regist_input() {
	
		$this->set('action', 'regist');
		$this->set('class_path', 'conference/Conference');
		
		$this->view('conference/conference_input');
	}
	/**
	 * 新規登録
	 */
	public function regist() {
		
		$input = $this->get_attribute();
		$this->load->model('conference/ConferenceRegistModel', 'model');
		$this->load->library('dao/ConferenceDao');
		
		$msgs = $this->model->validation($input);
		
		if ($msgs != null) {
			$this->set_err_info($msgs);
			$this->view('conference/conference_input');
			return;
		}
		
		$this->model->db_regist($input);
		$this->redirect_js(base_url(). 'conference/ConferenceList');
	}
	public function modify_input($id) {
		
		$this->load->model('conference/ConferenceRegistModel', 'model');
		$this->load->library('dao/ConferenceDao');
		
		$this->set_attribute($this->model->get_conference_info($id));
		$this->set('action', 'modify');
		$this->set('class_path', 'conference/Conference');
		
		$this->view('conference/conference_input');
	}
	/**
	 * 更新
	 */
	public function modify() {
		
		$input = $this->get_attribute();
		$this->load->model('conference/ConferenceRegistModel', 'model');
		$this->load->library('dao/ConferenceDao');
		
		$msgs = $this->model->validation($input);
		
		if ($msgs != null) {
			$this->set_err_info($msgs);
			$this->view('conference/conference_input');
			return;
		}
		
		$this->model->db_modify($input);
		$this->redirect_js(base_url(). 'conference/ConferenceList');
	}
}
?>