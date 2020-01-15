<?php

/**
 * AtiCategoryRegistModel
 * @author takanori_gozu
 *
 */
class AtiCategoryRegistModel extends MY_Model {
	
	/**
	 * 詳細
	 */
	public function get_ati_category_info($id) {
		
		$this->set_table(AtiCategoryDao::TABLE_NAME, 'master');
		
		$this->add_where(AtiCategoryDao::COL_ID, $id);
		
		return $this->do_select_info();
	}
	
	/**
	 * バリデーション
	 */
	public function validation($input) {
		
		$category_name = $input['category_name'];
		$category_detail = $input['category_detail'];
		
		$msgs = array();
		
		//未入力チェック
		if (trim($category_name) == '') $msgs[] = $this->lang->line('err_required', array($this->lang->line('category_name')));
		if (trim($category_detail) == '') $msgs[] = $this->lang->line('err_required', array($this->lang->line('category_detail')));
		
		if ($msgs != null) return $msgs;
		
		//文字数チェック
		if (strlen(trim($category_name)) > 20) $msgs[] = $this->lang->line('err_max_length', array($this->lang->line('category_name'), 20));
		if (strlen(trim($category_detail)) > 40) $msgs[] = $this->lang->line('err_max_length', array($this->lang->line('category_detail'), 40));
		
		return $msgs;
	}
	
	/**
	 * 新規登録
	 */
	public function db_regist($input) {
		
		$this->set_table(AtiCategoryDao::TABLE_NAME, 'master');
		
		$this->add_col_val(AtiCategoryDao::COL_CATEGORY_NAME, $input['category_name']);
		$this->add_col_val(AtiCategoryDao::COL_CATEGORY_DETAIL, $input['category_detail']);
		
		$this->do_insert();
	}
	
	/**
	 * 更新
	 */
	public function db_modify($input) {
		
		$this->set_table(AtiCategoryDao::TABLE_NAME, 'master');
		
		$this->add_col_val(AtiCategoryDao::COL_CATEGORY_NAME, $input['category_name']);
		$this->add_col_val(AtiCategoryDao::COL_CATEGORY_DETAIL, $input['category_detail']);
		$this->add_where(AtiCategoryDao::COL_ID, $input['id']);
		
		$this->do_update();
	}
}
?>