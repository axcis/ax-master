<?php

/**
 * EmployeeListModel
 * @author takanori_gozu
 *
 */
class EmployeeListModel extends EmployeeBaseModel {
	
	/**
	 * 一覧
	 */
	public function get_list($search = null) {
		
		$this->set_table(EmployeeDao::TABLE_NAME, 'master');
		
		$this->add_select(EmployeeDao::COL_ID);
		$this->add_select(EmployeeDao::COL_NAME);
		$this->add_select(EmployeeDao::COL_HIRAGANA);
		$this->add_select(EmployeeDao::COL_LOGIN_ID);
		$this->add_select(EmployeeDao::COL_DIVISION_ID);
		$this->add_select(EmployeeDao::COL_EMAIL_ADDRESS);
		$this->add_select(EmployeeDao::COL_USER_LEVEL);
		$this->add_select(EmployeeDao::COL_RETIREMENT);
		
		$this->add_where(EmployeeDao::COL_NAME, $this->lang->line('administrator'), self::COMP_NOT_EQUAL);
		
		//退職者データ表示制御
		if (!isset($search['retirement_show'])) {
			$this->add_where(EmployeeDao::COL_RETIREMENT, '0');
		}
		
		//検索
		if ($search != null) {
			$this->set_search_like($search, EmployeeDao::COL_NAME, 'search_name');
			$this->set_search($search, EmployeeDao::COL_DIVISION_ID, 'search_division_id');
		}
		
		$employee_list = $this->do_select();
		
		//マージ
		$division_map = $this->get_division_map();
		$user_level_map = $this->get_user_level_map();
		
		foreach ($employee_list as &$row) {
			$division_id = $row[EmployeeDao::COL_DIVISION_ID];
			$user_level = $row[EmployeeDao::COL_USER_LEVEL];
			$row[EmployeeDao::COL_DIVISION_ID] = $division_map[$division_id];
			$row[EmployeeDao::COL_USER_LEVEL] = $user_level_map[$user_level];
			if ($row[EmployeeDao::COL_RETIREMENT] == '1') {
				$row[EmployeeDao::COL_RETIREMENT] = '済';
			} else {
				$row[EmployeeDao::COL_RETIREMENT] = '';
			}
		}
		
		return $employee_list;
	}
	
	/**
	 * 項目名
	 */
	public function get_list_col() {
		
		$list_col = array();
		
		$list_col[] = array('width' => 70, 'value' => ''); //編集
		$list_col[] = array('width' => 70, 'value' => 'ID');
		$list_col[] = array('width' => 150, 'value' => '社員名');
		$list_col[] = array('width' => 150, 'value' => '社員名(かな)');
		$list_col[] = array('width' => 150, 'value' => 'ログインID');
		$list_col[] = array('width' => 150, 'value' => '所属部署');
		$list_col[] = array('width' => 300, 'value' => 'メールアドレス');
		$list_col[] = array('width' => 150, 'value' => '権限');
		$list_col[] = array('width' => 70, 'value' => '退職');
		
		return $list_col;
	}
	
	/**
	 * リンク
	 */
	public function get_link_list() {
		
		$link_list = array();
		
		$link_list[] = array('url' => 'employee/EmployeeRegist/regist_input', 'class' => 'fa fa-pencil', 'value' => '登録');
		$link_list[] = array('url' => 'employee/EmployeeList/output', 'class' => 'fa fa-file-text', 'value' => '出力');
		
		return $link_list;
	}
}
?>