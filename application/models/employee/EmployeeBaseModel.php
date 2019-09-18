<?php

/**
 * EmployeeBaseModel
 * 社員マスタ画面の共通モデル
 * @author takanori_gozu
 *
 */
class EmployeeBaseModel extends MY_Model {
	
	/**
	 * 権限レベルのマッピング
	 */
	public function get_user_level_map() {
		
		$map = array();
		
		$map[''] = '権限を選択';
		$map['1'] = '管理者';
		$map['2'] = 'リーダー';
		$map['3'] = 'サブリーダー';
		$map['4'] = 'メンバー';
		
		return $map;
	}
	
	/**
	 * 部署のマッピング
	 */
	public function get_division_map() {
		
		$this->set_table(DivisionDao::TABLE_NAME, 'master');
		
		$this->add_select(DivisionDao::COL_ID);
		$this->add_select(DivisionDao::COL_NAME);
		
		$list = array();
		
		$list[''] = '部署を選択';
		$list += $this->key_value_map($this->do_select());
		
		return $list;
	}
}
?>