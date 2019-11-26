<?php

/**
 * TrainingCategoryRegistModel
 * @author takanori_gozu
 *
 */
class TrainingCategoryRegistModel extends MY_Model {
	
	/**
	 * 詳細
	 */
	public function get_training_category_info($id) {
		
		$this->set_table(TrainingCategoryDao::TABLE_NAME, 'master');
		
		$this->add_where(TrainingCategoryDao::COL_ID, $id);
		
		return $this->do_select_info();
	}
	
	/**
	 * バリデーション
	 */
	public function validation($input) {
		
		$training_name = $input['training_name'];
		$text_file_name = $input['text_file_name']. '.pdf';
		$dl_text_name = $input['dl_text_name']. '.pdf';
		$training_info = $input['training_info'];
		
		$msgs = array();
		
		//未入力チェック
		if (trim($training_name) == '') $msgs[] = $this->lang->line('err_required', array($this->lang->line('training_name')));
		if (trim($text_file_name) == '') $msgs[] = $this->lang->line('err_required', array($this->lang->line('text_file_name')));
		if (trim($dl_text_name) == '') $msgs[] = $this->lang->line('err_required', array($this->lang->line('dl_text_name')));
		if (trim($training_info) == '') $msgs[] = $this->lang->line('err_required', array($this->lang->line('training_info')));
		
		if ($msgs != null) return $msgs;
		
		//文字数チェック
		if (strlen(trim($training_name)) > 100) $msgs[] = $this->lang->line('err_max_length', array($this->lang->line('training_name'), 100));
		if (strlen(trim($text_file_name)) > 100) $msgs[] = $this->lang->line('err_max_length', array($this->lang->line('text_file_name'), 100));
		if (strlen(trim($dl_text_name)) > 200) $msgs[] = $this->lang->line('err_max_length', array($this->lang->line('dl_text_name'), 200));
		
		return $msgs;
	}
	
	/**
	 * 新規登録
	 */
	public function db_regist($input) {
		
		$this->set_table(TrainingCategoryDao::TABLE_NAME, 'master');
		
		$this->add_col_val(TrainingCategoryDao::COL_TRAINING_NAME, $input['training_name']);
		$this->add_col_val(TrainingCategoryDao::COL_TEXT_FILE_NAME, $input['text_file_name']. '.pdf');
		$this->add_col_val(TrainingCategoryDao::COL_DL_TEXT_NAME, $input['dl_text_name']. '.pdf');
		$this->add_col_val(TrainingCategoryDao::COL_TRAINING_INFO, $input['training_info']);
		
		$this->do_insert();
	}
	
	/**
	 * 更新
	 */
	public function db_modify($input) {
		
		$this->set_table(TrainingCategoryDao::TABLE_NAME, 'master');
		
		$this->add_col_val(TrainingCategoryDao::COL_TRAINING_NAME, $input['training_name']);
		$this->add_col_val(TrainingCategoryDao::COL_TEXT_FILE_NAME, $input['text_file_name']. '.pdf');
		$this->add_col_val(TrainingCategoryDao::COL_DL_TEXT_NAME, $input['dl_text_name']. '.pdf');
		$this->add_col_val(TrainingCategoryDao::COL_TRAINING_INFO, $input['training_info']);
		
		$this->add_where(TrainingCategoryDao::COL_ID, $input['id']);
		
		$this->do_update();
	}
}
?>