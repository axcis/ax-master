<?php

/**
 * TrainingQuestionBaseModel
 * @author takanori_gozu
 *
 */
class TrainingQuestionBaseModel extends MY_Model {
	
	/**
	 * カテゴリのマッピング
	 */
	public function get_training_category_map($no_select_show = true) {
		
		$this->set_table(TrainingCategoryDao::TABLE_NAME, 'master');
		
		$this->add_select(TrainingCategoryDao::COL_ID);
		$this->add_select_as(TrainingCategoryDao::COL_TRAINING_NAME, 'name');
		
		$map = array();
		
		if ($no_select_show) $map[''] = '研修を選択';
		$map += $this->key_value_map($this->do_select());
		
		return $map;
	}
}
?>