<?php

/**
 * HolidayListModel
 * @author masahide_kinutani
 *
 */
class HolidayListModel extends MY_Model {
	
	/**
	 * 一覧
	 */
	public function get_list($search = null) {
		
		$this->set_table(HolidayDao::TABLE_NAME, 'master');
		
		$this->add_select_as(HolidayDao::COL_HOLIDAY_DATE, 'id');
		$this->add_select(HolidayDao::COL_HOLIDAY_NAME);
		
		if ($search != null) {
			$this->add_where(HolidayDao::COL_HOLIDAY_DATE, $search['search_date']);
		}
		
		return $this->do_select();
	}
	
	/**
	 * 項目名
	 */
	public function get_list_col() {
		
		$list_col = array();
		
		$list_col[] = array('width' => 70, 'value' => ''); //編集
		$list_col[] = array('width' => 150, 'value' => '祝祭日日付');
		$list_col[] = array('width' => 350, 'value' => '祝祭日名');
		
		return $list_col;
	}
	
	/**
	 * リンク
	 */
	public function get_link_list() {
		
		$link_list = array();
		
		$link_list[] = array('url' => 'holiday/HolidayRegist/regist_input', 'class' => 'fa fa-pencil', 'value' => '登録');
		$link_list[] = array('url' => 'holiday/HolidayList/output', 'class' => 'fa fa-file-text', 'value' => '出力');
		
		return $link_list;
	}
}
?>