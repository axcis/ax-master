<?php

/**
 * HolidayRegistModel
 * @author masahide_kinutani
 *
 */
class HolidayRegistModel extends MY_Model {
	
	/**
	 * バリデーション
	 */
	public function validation($input) {
		
		$act = $input['action'];
		if ($act == 'regist') {
			$holiday_date = $input['holiday_date'];
		} else {
			$holiday_date = $input['id']; //hiddenでIDにセットしている
		}
		$holiday_name = $input['holiday_name'];
		
		$msgs = array();
		
		//未入力チェック
		if (trim($holiday_date) == '') $msgs[] = $this->lang->line('err_not_select', array($this->lang->line('holiday_date')));
		if (trim($holiday_name) == '') $msgs[] = $this->lang->line('err_required', array($this->lang->line('holiday_name')));
		
		if ($msgs != null) return $msgs;
		
		//祝祭日名は75文字以内
		if (mb_strlen(trim($holiday_name)) > 75) $msgs[] = $this->lang->line('err_max_length', array($this->lang->line('holiday_name'), 75));
		
		if ($msgs != null) return $msgs;
		
		if ($act == 'regist') {
			//登録チェック
			$this->set_table(HolidayDao::TABLE_NAME, 'master');
			
			$this->add_where(HolidayDao::COL_HOLIDAY_DATE, $holiday_date);
			
			$count = $this->do_count();
			
			if ($count > 0) $msgs[] = $this->lang->line('err_already_regist', array($this->lang->line('holiday_date')));
		}
		
		return $msgs;
	}
	
	/**
	 * 詳細
	 */
	public function get_holiday_info($holiday_date) {
		
		$this->set_table(HolidayDao::TABLE_NAME, 'master');
		
		$this->add_where(HolidayDao::COL_HOLIDAY_DATE, $holiday_date);
		
		return $this->do_select_info();
	}
	
	/**
	 * 新規登録
	 */
	public function db_regist($input) {
		
		$this->set_table(HolidayDao::TABLE_NAME, 'master');
		
		$this->add_col_val(HolidayDao::COL_HOLIDAY_DATE, $input['holiday_date']);
		$this->add_col_val(HolidayDao::COL_MONTH, substr($input['holiday_date'], 0, 7));
		$this->add_col_val(HolidayDao::COL_HOLIDAY_NAME, $input['holiday_name']);
		
		$this->do_insert();
	}
	
	/**
	 * 更新
	 */
	public function db_modify($input) {
		
		$this->set_table(HolidayDao::TABLE_NAME, 'master');
		
		$this->add_col_val(HolidayDao::COL_HOLIDAY_NAME, $input['holiday_name']);
		$this->add_where(HolidayDao::COL_HOLIDAY_DATE, $input['id']);
		
		$this->do_update();
	}
}
?>