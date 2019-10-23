<?php

/**
 * ConferenceRegistModel
 * @author yusuke_hoshino
 *
 */
class ConferenceRegistModel extends MY_Model {
	/**
	 * 入力チェック
	 */
	public function validation($input) {
		
		$room_name = $input['room_name'];
		
		$msgs = array();
		
		//未入力チェック
		if (trim($room_name) == '') $msgs[] = $this->lang->line('err_required', array($this->lang->line('room_name')));
		
		//部署名は100文字以内
		if (mb_strlen(trim($room_name)) > 100) $msgs[] = $this->lang->line('err_max_length', array($this->lang->line('room_name'), 100));
		
		return $msgs;
	}
	/**
	 * 詳細
	 */
	public function get_conference_info($id) {
		
		$this->set_table(ConferenceDao::TABLE_NAME, 'master');
		
		$this->add_where(ConferenceDao::COL_ID, $id);
		
		return $this->do_select_info();
	}
	/**
	 * 新規登録
	 */
	public function db_regist($input) {
		
		$this->set_table(ConferenceDao::TABLE_NAME, 'master');
		
		$this->add_col_val(ConferenceDao::COL_ROOM_NAME, $input['room_name']);
		
		$this->do_insert();
	}
	/**
	 * 更新
	 */
	public function db_modify($input) {
		
		$this->set_table(ConferenceDao::TABLE_NAME, 'master');
		
		$this->add_col_val(ConferenceDao::COL_ROOM_NAME, $input['room_name']);
		$this->add_where(ConferenceDao::COL_ID, $input['id']);
		
		$this->do_update();
	}
}
?>