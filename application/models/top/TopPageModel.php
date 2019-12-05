<?php

/**
 * TopPageModel
 * @author takanori_gozu
 *
 */
class TopPageModel extends MY_Model {
	
	/**
	 * コンテンツ一覧
	 */
	public function get_contents_list() {
		
		$list = array();
		
		//コンテンツ情報の記載
		$list[] = array('btn_name' => '社員管理', 'url' => base_url(). 'employee/EmployeeList', 'detail' => $this->lang->line('employee_detail'));
		$list[] = array('btn_name' => '部署管理', 'url' => base_url(). 'division/DivisionList', 'detail' => $this->lang->line('division_detail'));
		$list[] = array('btn_name' => '社内研修カテゴリ管理', 'url' => base_url(). 'training_category/TrainingCategoryList', 'detail' => $this->lang->line('training_category_detail'));
		$list[] = array('btn_name' => '社内研修問題管理', 'url' => base_url(). 'training_question/TrainingQuestionList', 'detail' => $this->lang->line('training_question_detail'));
		$list[] = array('btn_name' => '祝祭日管理', 'url' => base_url(). 'holiday/HolidayList', 'detail' => $this->lang->line('holiday_detail'));
		$list[] = array('btn_name' => '社内文書カテゴリ管理', 'url' => base_url(). 'document_category/DocumentCategoryList', 'detail' => $this->lang->line('document_category_detail'));
		$list[] = array('btn_name' => '会議室管理', 'url' => base_url(). 'conference/ConferenceList', 'detail' => $this->lang->line('conference_detail'));
		$list[] = array('btn_name' => 'パスワードリセット', 'url' => base_url(). 'password/PasswordReset', 'detail' => $this->lang->line('password_reset_detail'));
		
		return $list;
	}
}
?>