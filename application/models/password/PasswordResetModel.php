<?php

/**
 * PasswordResetModel
 * @author takanori_gozu
 *
 */
class PasswordResetModel extends MY_Model {
	
	/**
	 * 社員のマッピング
	 */
	public function get_employee_map() {
		
		$this->set_table(EmployeeDao::TABLE_NAME, 'master');
		
		$this->add_select(EmployeeDao::COL_ID);
		$this->add_select(EmployeeDao::COL_NAME);
		
		$this->add_where(EmployeeDao::COL_RETIREMENT, '0'); //退職者は除く
		$this->add_where(EmployeeDao::COL_NAME, $this->lang->line('administrator'), self::COMP_NOT_EQUAL);
		
		$map = array();
		
		$map[''] = 'ユーザーを選択';
		$map += $this->key_value_map($this->do_select());
		
		return $map;
	}
	
	/**
	 * バリデーション
	 */
	public function validation($input) {
		
		$user_id = $input['employee_id'];
		$password = $input['password'];
		
		$msgs = array();
		
		//未入力チェック
		if (trim($user_id) == '') $msgs[] = $this->lang->line('err_not_select', array($this->lang->line('user_id')));
		if (trim($password) == '') $msgs[] = $this->lang->line('err_required', array($this->lang->line('password')));
		
		if ($msgs != null) return $msgs;
		
		if (mb_strlen($password) > 8) $msgs[] = $this->lang->line('err_max_length', array($this->lang->line('password'), 8));
		
		if (!preg_match("/^[a-zA-Z0-9]+$/", $password)) $msgs[] = $this->lang->line('err_regex_match', array($this->lang->line('password')));
		
		return $msgs;
	}
	
	/**
	 * パスワードリセット
	 */
	public function db_modify($input) {
		
		$this->set_table(EmployeeDao::TABLE_NAME, 'master');
		
		$this->add_col_val(EmployeeDao::COL_PASSWORD, password_hash($input['password'], PASSWORD_BCRYPT));
		$this->add_where(EmployeeDao::COL_ID, $input['employee_id']);
		
		$this->do_update();
	}
}
?>