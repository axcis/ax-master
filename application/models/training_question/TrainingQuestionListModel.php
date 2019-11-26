<?php

/**
 * TrainingQuestionListModel
 * @author takanori_gozu
 *
 */
class TrainingQuestionListModel extends TrainingQuestionBaseModel {
	
	/**
	 * 一覧
	 */
	public function get_list($search = null) {
		
		$this->set_table(TrainingQuestionDao::TABLE_NAME, 'master');
		
		$this->add_select_as("''", 'training_name');
		$this->add_select(TrainingQuestionDao::COL_ID);
		$this->add_select(TrainingQuestionDao::COL_TRAINING_TYPE);
		$this->add_select(TrainingQuestionDao::COL_QUESTION);
		$this->add_select(TrainingQuestionDao::COL_ANSWER_LIST);
		$this->add_select(TrainingQuestionDao::COL_ANSWER);
		$this->add_select(TrainingQuestionDao::COL_POINT);
		
		$this->add_order(TrainingQuestionDao::COL_TRAINING_TYPE);
		$this->add_order(TrainingQuestionDao::COL_ID);
		
		if ($search != null) {
			$this->set_search($search, TrainingQuestionDao::COL_TRAINING_TYPE, 'search_training_type');
		}
		
		$list = $this->do_select();
		
		$training_category_map = $this->get_training_category_map(false);
		
		foreach ($list as &$row) {
			$row['training_name'] = $training_category_map[$row[TrainingQuestionDao::COL_TRAINING_TYPE]];
		}
		
		return $list;
	}
	
	/**
	 * 項目名
	 */
	public function get_list_col() {
		
		$list_col = array();
		
		$list_col[] = array('width' => 70, 'value' => ''); //編集
		$list_col[] = array('width' => 150, 'value' => '研修名');
		$list_col[] = array('width' => 70, 'value' => '番号');
		$list_col[] = array('width' => 350, 'value' => '問題');
		$list_col[] = array('width' => 350, 'value' => '解答一覧');
		$list_col[] = array('width' => 150, 'value' => '解答番号');
		$list_col[] = array('width' => 70, 'value' => '得点');
		
		return $list_col;
	}
	
	/**
	 * リンク
	 */
	public function get_link_list() {
		
		$link_list = array();
		
		$link_list[] = array('url' => 'training_question/TrainingQuestionRegist/regist_input', 'class' => 'fa fa-pencil', 'value' => '登録');
		$link_list[] = array('url' => 'training_question/TrainingQuestionList/output', 'class' => 'fa fa-file-text', 'value' => '出力');
		
		return $link_list;
	}
	
	/**
	 * 	Excel出力時の項目除外
	 */
	public function unset_list(&$list) {
		
		foreach ($list as &$row) {
			foreach ($row as $key => $value) {
				if ($key == TrainingQuestionDao::COL_TRAINING_TYPE) {
					unset($row[$key]);
				}
			}
		}
	}
}
?>