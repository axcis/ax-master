<?php

/**
 * DivisionRegistModel
 * @author takanori_gozu
 *
 */
class DivisionRegistModel extends MY_Model {
	
	/**
	 * 入力チェック
	 */
	public function validation($input) {
		
		$division_name = $input['name'];
		
		$msgs = array();
		
		//未入力チェック
		if (trim($division_name) == '') $msgs[] = $this->lang->line('err_required', array($this->lang->line('division_name')));
		
		//部署名は100文字以内
		if (mb_strlen(trim($division_name)) > 100) $msgs[] = $this->lang->line('err_max_length', array($this->lang->line('division_name'), 100));
		
		return $msgs;
	}
	
	/**
	 * 詳細
	 */
	public function get_division_info($id) {
		
		$this->set_table(DivisionDao::TABLE_NAME, 'master');
		
		$this->add_where(DivisionDao::COL_ID, $id);
		
		return $this->do_select_info();
	}
	
	/**
	 * 新規登録
	 */
	public function db_regist($input) {
		
		$this->set_table(DivisionDao::TABLE_NAME, 'master');
		
		$this->add_col_val(DivisionDao::COL_NAME, $input['name']);
		
		$this->do_insert();
	}
	
	/**
	 * 更新
	 */
	public function db_modify($input) {
		
		$this->set_table(DivisionDao::TABLE_NAME, 'master');
		
		$this->add_col_val(DivisionDao::COL_NAME, $input['name']);
		$this->add_where(DivisionDao::COL_ID, $input['id']);
		
		$this->do_update();
	}
}
?>