<?php

/**
 * EmployeeRegistModel
 * @author takanori_gozu
 *
 */
class EmployeeRegistModel extends EmployeeBaseModel {
	
	/**
	 * 詳細
	 */
	public function get_employee_info($id) {
		
		$this->set_table(EmployeeDao::TABLE_NAME, 'master');
		
		$this->add_where(EmployeeDao::COL_ID, $id);
		
		return $this->do_select_info();
	}
	
	/**
	 * バリデーション
	 */
	public function validation($input) {
		
		$act = $input['action'];
		$id = $input['id'];
		$name = $input['name'];
		$hiragana = $input['hiragana'];
		$login_id = $input['login_id'];
		if ($act == 'regist') $password = $input['password'];
		$email_address = $input['email_address']. $this->lang->line('email_domain');
		$division_id = $input['division_id'];
		$user_level = $input['user_level'];
		$hire_date = $input['hire_date'];
		$retirement = isset($input['retirement']) ? $input['retirement'] : '';
		
		$msgs = array();
		
		if (trim($name) == '') $msgs[] = $this->lang->line('err_required', array($this->lang->line('employee_name')));
		if (trim($hiragana) == '') $msgs[] = $this->lang->line('err_required', array($this->lang->line('employee_name_kana')));
		if (trim($login_id) == '') $msgs[] = $this->lang->line('err_required', array($this->lang->line('login_id')));
		if ($act == 'regist') {
			if (trim($password) == '') $msgs[] = $this->lang->line('err_required', array($this->lang->line('password')));
		}
		if (trim($email_address) == '') $msgs[] = $this->lang->line('err_required', array($this->lang->line('email_address')));
		if (trim($division_id) == '') $msgs[] = $this->lang->line('err_not_select', array($this->lang->line('division')));
		if (trim($user_level) == '') $msgs[] = $this->lang->line('err_not_select', array($this->lang->line('user_level')));
		if (trim($hire_date) == '') $msgs[] = $this->lang->line('err_not_select', array($this->lang->line('hire_date')));
		
		//未入力チェックにひっかかれば、ここでreturn
		if ($msgs != null) {
			return $msgs;
		}
		
		//パスワードは8文字以内
		if ($act == 'regist') {
			if (strlen(trim($password)) > 8) $msgs[] = $this->lang->line('err_max_length', array($this->lang->line('password'), 8));
		}
		
		//メールアドレスは200文字以内
		if (strlen(trim($email_address)) > 200) $msgs[] = $this->lang->line('err_max_length', array($this->lang->line('email_address'), 200));
		
		//メールアドレスの判定
		if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email_address)) {
			$msgs[] = $this->lang->line('err_regex_match', array($this->lang->line('email_address')));
		}
		
		//ユーザーID'administrator'は登録不可
		if (trim($login_id) == 'administrator') $msgs[] = $this->lang->line('err_not_regist', array($login_id));
		
		//退職済みの場合、退職日未選択はエラー
		if ($act == 'modify' && $retirement == '1') {
			if ($input['retirement_date'] == '') $msgs[] = $this->lang->line('err_not_select', array($this->lang->line('retirement_date')));
		}
		
		if ($msgs != null) return $msgs;
		
		//登録済みログインIDは登録不可
		$this->set_table(EmployeeDao::TABLE_NAME, 'master');
		$this->add_where(EmployeeDao::COL_LOGIN_ID, $login_id);
		if ($act == 'modify') {
			$this->add_where(EmployeeDao::COL_ID, $id, self::COMP_NOT_EQUAL);
		}
		$count = $this->do_count();
		if ($count > 0) {
			$msgs[] = $this->lang->line('err_already_regist', array($this->lang->line('login_id')));
		}
		
		//登録済みメールアドレスは登録不可
		$this->set_table(EmployeeDao::TABLE_NAME, 'master');
		$this->add_where(EmployeeDao::COL_EMAIL_ADDRESS, $email_address);
		if ($act == 'modify') {
			$this->add_where(EmployeeDao::COL_ID, $id, self::COMP_NOT_EQUAL);
		}
		$count = $this->do_count();
		if ($count > 0) {
			$msgs[] = $this->lang->line('err_already_regist', array($this->lang->line('email_address')));
		}
		
		return $msgs;
	}
	
	/**
	 * 新規登録
	 */
	public function db_regist($input) {
		
		$this->set_table(EmployeeDao::TABLE_NAME, 'master');
		
		$this->add_col_val(EmployeeDao::COL_NAME, $input['name']);
		$this->add_col_val(EmployeeDao::COL_HIRAGANA, $input['hiragana']);
		$this->add_col_val(EmployeeDao::COL_LOGIN_ID, $input['login_id']);
		$this->add_col_val(EmployeeDao::COL_PASSWORD, password_hash($input['password'], PASSWORD_BCRYPT));
		$this->add_col_val(EmployeeDao::COL_EMAIL_ADDRESS, $input['email_address']. $this->lang->line('email_domain'));
		$this->add_col_val(EmployeeDao::COL_USER_LEVEL, $input['user_level']);
		$this->add_col_val(EmployeeDao::COL_DIVISION_ID, $input['division_id']);
		$this->add_col_val(EmployeeDao::COL_HIRE_DATE, $input['hire_date']);
		$this->add_col_val(EmployeeDao::COL_RETIREMENT, '0');
		$this->add_col_val(EmployeeDao::COL_UPD_USER_ID, 1); //管理者(1)で登録
		$this->add_col_val(EmployeeDao::COL_UPD_USER_NAME, $this->lang->line('administrator'));
		
		$this->do_insert();
	}
	
	/**
	 * 更新
	 */
	public function db_modify($input) {
		
		$this->set_table(EmployeeDao::TABLE_NAME, 'master');
		
		$this->add_col_val(EmployeeDao::COL_NAME, $input['name']);
		$this->add_col_val(EmployeeDao::COL_HIRAGANA, $input['hiragana']);
		$this->add_col_val(EmployeeDao::COL_LOGIN_ID, $input['login_id']);
		$this->add_col_val(EmployeeDao::COL_EMAIL_ADDRESS, $input['email_address']. $this->lang->line('email_domain'));
		$this->add_col_val(EmployeeDao::COL_USER_LEVEL, $input['user_level']);
		$this->add_col_val(EmployeeDao::COL_DIVISION_ID, $input['division_id']);
		$this->add_col_val(EmployeeDao::COL_HIRE_DATE, $input['hire_date']);
		if (isset($input['retirement'])) {
			$this->add_col_val(EmployeeDao::COL_RETIREMENT, '1');
			$this->add_col_val(EmployeeDao::COL_RETIREMENT_DATE, $input['retirement_date']);
		} else {
			$this->add_col_val(EmployeeDao::COL_RETIREMENT, '0');
			$this->add_col_val(EmployeeDao::COL_RETIREMENT_DATE, null);
		}
		$this->add_col_val(EmployeeDao::COL_UPD_USER_ID, 1); //管理者(1)で登録
		$this->add_col_val(EmployeeDao::COL_UPD_USER_NAME, $this->lang->line('administrator'));
		
		$this->add_where(EmployeeDao::COL_ID, $input['id']);
		
		$this->do_update();
	}
}
?>