<?php

/**
 * TrainingQuestionListModel
 * @author takanori_gozu
 *
 */
class TrainingQuestionListModel extends MY_Model {
	
	/**
	 * 一覧
	 */
	public function get_list($training_type) {
		
		$this->set_table(TrainingQuestionDao::TABLE_NAME, 'master');
		
		$this->add_select(TrainingQuestionDao::COL_ID);
		$this->add_select(TrainingQuestionDao::COL_QUESTION);
		$this->add_select(TrainingQuestionDao::COL_ANSWER_LIST);
		$this->add_select(TrainingQuestionDao::COL_ANSWER);
		$this->add_select(TrainingQuestionDao::COL_POINT);
		
		$this->add_where(TrainingQuestionDao::COL_TRAINING_TYPE, $training_type);
		
		return $this->do_select();
	}
	
	/**
	 * 項目名
	 */
	public function get_list_col() {
		
		$list_col = array();
		
		$list_col[] = array('width' => 70, 'value' => ''); //編集
		$list_col[] = array('width' => 150, 'value' => '問題番号');
		$list_col[] = array('width' => 350, 'value' => '問題');
		$list_col[] = array('width' => 350, 'value' => '解答一覧');
		$list_col[] = array('width' => 150, 'value' => '解答番号');
		$list_col[] = array('width' => 70, 'value' => '得点');
		
		return $list_col;
	}
	
	/**
	 * リンク
	 */
	public function get_link_list($path) {
		
		$link_list = array();
		
		$link_list[] = array('url' => $path. 'Regist/regist_input', 'class' => 'fa fa-pencil', 'value' => '登録');
		$link_list[] = array('url' => $path. 'List/output', 'class' => 'fa fa-file-text', 'value' => '出力');
		
		return $link_list;
	}
}
?>