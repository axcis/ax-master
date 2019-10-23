<?php

/**
 * ConferenceListModel
 * @author yusuke_hoshino
 *
 */
class ConferenceListModel extends MY_Model {
	/**
	 * 一覧
	 */
	public function get_list() {
		
		$this->set_table(ConferenceDao::TABLE_NAME, 'master');
		
		$this->add_select(ConferenceDao::COL_ID);
		$this->add_select(ConferenceDao::COL_ROOM_NAME);
		
		return $this->do_select();
	}
	/**
	 * 項目名
	 */
	public function get_list_col() {
		
		$list_col = array();
		
		$list_col[] = array('width' => 70, 'value' => ''); //編集
		$list_col[] = array('width' => 150, 'value' => 'ID');
		$list_col[] = array('width' => 350, 'value' => '会議室名');
		
		return $list_col;
	}
	/**
	 * リンク
	 */
	public function get_link_list() {
		
		$link_list = array();
		
		$link_list[] = array('url' => 'conference/ConferenceRegist/regist_input', 'class' => 'fa fa-pencil', 'value' => '登録');
		$link_list[] = array('url' => 'conference/ConferenceList/output', 'class' => 'fa fa-file-text', 'value' => '出力');
		
		return $link_list;
	}
}
?>