<?php

/**
 * TrainingQuestionRegistModel
 * @author takanori_gozu
 *
 */
class TrainingQuestionRegistModel extends TrainingQuestionBaseModel {
	
	/**
	 * 詳細
	 */
	public function get_training_question_info($type_id) {
		
		$type_id = explode('-', $type_id);
		
		$type = $type_id[0];
		$id = $type_id[1];
		
		$this->set_table(TrainingQuestionDao::TABLE_NAME, 'master');
		
		$this->add_where(TrainingQuestionDao::COL_ID, $id);
		$this->add_where(TrainingQuestionDao::COL_TRAINING_TYPE, $type);
		
		$info = $this->do_select_info();
		
		//解答群はフォーマットを変換する
		$answer_list = $info['answer_list'];
		
		$info['answer_list'] = $this->change_to_input_format($answer_list);
		
		return $info;
	}
	
	/**
	 * バリデーション
	 */
	public function validation($input) {
		
		$act = $input['action'];
		$training_type = $input['training_type'];
		if ($act == 'regist') {
			$question_no = $input['question_no'];
		} else {
			$question_no = $input['id'];
		}
		$question = $input['question'];
		$answer_list = $input['answer_list'];
		$answer = $input['answer'];
		$point = $input['point'];
		
		$msgs = array();
		
		//未入力チェック
		if (trim($training_type) == '') $msgs[] = $this->lang->line('err_not_select', array($this->lang->line('training_name')));
		if ($act == 'regist') {
			if (trim($question_no) == '') $msgs[] = $this->lang->line('err_required', array($this->lang->line('question_no')));
		}
		if (trim($question) == '') $msgs[] = $this->lang->line('err_required', array($this->lang->line('question')));
		if (trim($answer_list) == '') $msgs[] = $this->lang->line('err_required', array($this->lang->line('answer_list')));
		if (trim($answer) == '') $msgs[] = $this->lang->line('err_required', array($this->lang->line('answer')));
		if (trim($point) == '') $msgs[] = $this->lang->line('err_required', array($this->lang->line('point')));
		
		if ($msgs != null) return $msgs;
		
		//フォーマットチェック
		if ($act == 'regist') {
			if (!preg_match("/^[0-9]+$/", $question_no) || $question_no == 0) {
				$msgs[] = $this->lang->line('err_regex_match', array($this->lang->line('question_no')));
			}
		}
		
		if (!preg_match("/^[0-9]+$/", $answer) || $answer == 0) {
			$msgs[] = $this->lang->line('err_regex_match', array($this->lang->line('answer')));
		}
		
		if (!preg_match("/^[0-9]+$/", $point) || $point == 0) {
			$msgs[] = $this->lang->line('err_regex_match', array($this->lang->line('point')));
		}
		
		if ($msgs != null) return $msgs;
		
		$answer_list = str_replace(array("\r\n","\r","\n"), "\n", $answer_list);
		
		//配列に変化し、空白行を詰める
		$answer_list = explode("\n", $answer_list);
		$answer_list = array_map('trim', $answer_list);
		$answer_list = array_filter($answer_list, 'strlen');
		
		$count = count($answer_list);
		
		//選択肢より多い答えの番号は登録不可
		if ($count < $answer) {
			$msgs[] = $this->lang->line('err_not_match', array($this->lang->line('answer'), '選択肢の個数'));
		}
		
		if ($msgs != null) return $msgs;
		
		//新規の場合、問題番号が重複していないかチェックする
		if ($act == 'regist') {
			
			$this->set_table(TrainingQuestionDao::TABLE_NAME, 'master');
			
			$this->add_where(TrainingQuestionDao::COL_ID, $question_no);
			$this->add_where(TrainingQuestionDao::COL_TRAINING_TYPE, $training_type);
			
			$count = $this->do_count();
			
			if ($count > 0) $msgs[] = $this->lang->line('err_already_regist', array($this->lang->line('question_no')));
		}
		
		if ($msgs != null) return $msgs;
		
		//100点を超える登録は不可
		$this->set_table(TrainingQuestionDao::TABLE_NAME, 'master');
		
		$this->add_select_sum_as(TrainingQuestionDao::COL_POINT);
		
		if ($act == 'modify') {
			$this->add_where(TrainingQuestionDao::COL_ID, $question_no, self::COMP_NOT_EQUAL);
		}
		
		$this->add_where(TrainingQuestionDao::COL_TRAINING_TYPE, $training_type);
		
		$result = $this->do_select();
		
		if (($result[0]['point'] + $point) > 100) {
			$msgs[] = $this->lang->line('err_over', array('点数の合計', '100点'));
		}
		
		return $msgs;
	}
	
	/**
	 * 新規登録
	 */
	public function db_regist($input) {
		
		$this->set_table(TrainingQuestionDao::TABLE_NAME, 'master');
		
		$this->add_col_val(TrainingQuestionDao::COL_ID, $input['question_no']);
		$this->add_col_val(TrainingQuestionDao::COL_QUESTION, $input['question']);
		$this->add_col_val(TrainingQuestionDao::COL_ANSWER_LIST, $this->change_to_db_format($input['answer_list']));
		$this->add_col_val(TrainingQuestionDao::COL_ANSWER, $input['answer']);
		$this->add_col_val(TrainingQuestionDao::COL_POINT, $input['point']);
		$this->add_col_val(TrainingQuestionDao::COL_TRAINING_TYPE, $input['training_type']);
		
		$this->do_insert();
	}
	
	/**
	 * 更新
	 */
	public function db_modify($input) {
		
		$this->set_table(TrainingQuestionDao::TABLE_NAME, 'master');
		
		$this->add_col_val(TrainingQuestionDao::COL_QUESTION, $input['question']);
		$this->add_col_val(TrainingQuestionDao::COL_ANSWER_LIST, $this->change_to_db_format($input['answer_list']));
		$this->add_col_val(TrainingQuestionDao::COL_ANSWER, $input['answer']);
		$this->add_col_val(TrainingQuestionDao::COL_POINT, $input['point']);
		
		$this->add_where(TrainingQuestionDao::COL_ID, $input['id']);
		$this->add_where(TrainingQuestionDao::COL_TRAINING_TYPE, $input['training_type']);
		
		$this->do_update();
	}
	
	/**
	 * 解答群のフォーマットを入力用に変更する
	 */
	private function change_to_input_format($list) {
		
		$answer_list = '';
		
		parse_str($list, $arr);
		
		foreach ($arr as $value) {
			if ($answer_list != '')  $answer_list .= "\n";
			$answer_list .= $value;
		}
		
		return $answer_list;
	}
	
	/**
	 * 解答群のフォーマットをDB登録用に変更する
	 */
	private function change_to_db_format($list) {
		
		$answer_list = '';
		$idx = 1;
		
		$list = str_replace(array("\r\n","\r","\n"), "\n", $list);
		
		//配列に変化し、空白行を詰める
		$arr = explode("\n", $list);
		$arr = array_map('trim', $arr);
		$arr = array_filter($arr, 'strlen');
		
		foreach ($arr as $value) {
			if ($idx > 1) $answer_list .= '&';
			$answer_list .= $idx. '='. $value;
			$idx++;
		}
		
		return $answer_list;
	}
}
?>