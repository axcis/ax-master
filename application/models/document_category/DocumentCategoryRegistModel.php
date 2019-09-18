<?php

/**
 * DocumentCategoryRegistModel
 * @author takanori_gozu
 *
 */
class DocumentCategoryRegistModel extends MY_Model {
	
	/**
	 * バリデーション
	 */
	public function validation($input) {
		
		$category_name = $input['category_name'];
		
		$msgs = array();
		
		//未入力チェック
		if (trim($category_name) == '') $msgs[] = $this->lang->line('err_required', array($this->lang->line('category_name')));
		
		//部署名は100文字以内
		if (mb_strlen(trim($category_name)) > 100) $msgs[] = $this->lang->line('err_max_length', array($this->lang->line('category_name'), 100));
		
		return $msgs;
	}
	
	/**
	 * 詳細
	 */
	public function get_document_category_info($id) {
		
		$this->set_table(DocumentCategoryDao::TABLE_NAME, 'master');
		
		$this->add_where(DocumentCategoryDao::COL_ID, $id);
		
		return $this->do_select_info();
	}
	
	/**
	 * 新規登録
	 */
	public function db_regist($input) {
		
		$this->set_table(DocumentCategoryDao::TABLE_NAME, 'master');
		
		$this->add_col_val(DocumentCategoryDao::COL_CATEGORY_NAME, $input['category_name']);
		
		$this->do_insert();
	}
	
	/**
	 * 更新
	 */
	public function db_modify($input) {
		
		$this->set_table(DocumentCategoryDao::TABLE_NAME, 'master');
		
		$this->add_col_val(DocumentCategoryDao::COL_CATEGORY_NAME, $input['category_name']);
		$this->add_where(DocumentCategoryDao::COL_ID, $input['id']);
		
		$this->do_update();
	}
}
?>