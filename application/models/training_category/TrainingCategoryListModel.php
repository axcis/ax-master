<?php

/**
 * TrainingCategoryListModel
 * @author takanori_gozu
 *
 */
class TrainingCategoryListModel extends MY_Model {
	
	/**
	 * 一覧
	 */
	public function get_list() {
		
		$this->set_table(TrainingCategoryDao::TABLE_NAME, 'master');
		
		$this->add_select(TrainingCategoryDao::COL_ID);
		$this->add_select(TrainingCategoryDao::COL_TRAINING_NAME);
		$this->add_select(TrainingCategoryDao::COL_TEXT_FILE_NAME);
		$this->add_select(TrainingCategoryDao::COL_DL_TEXT_NAME);
		$this->add_select(TrainingCategoryDao::COL_TRAINING_INFO);
		
		return $this->do_select();
	}
	
	/**
	 * 項目名
	 */
	public function get_list_col() {
		
		$list_col = array();
		
		$list_col[] = array('width' => 70, 'value' => ''); //編集
		$list_col[] = array('width' => 70, 'value' => 'ID');
		$list_col[] = array('width' => 150, 'value' => '研修名');
		$list_col[] = array('width' => 150, 'value' => 'テキスト名(アップロード時)');
		$list_col[] = array('width' => 150, 'value' => 'テキスト名(ダウンロード時)');
		$list_col[] = array('width' => 350, 'value' => '詳細');
		
		return $list_col;
	}
	
	/**
	 * リンク
	 */
	public function get_link_list() {
		
		$link_list = array();
		
		$link_list[] = array('url' => 'training_category/TrainingCategoryRegist/regist_input', 'class' => 'fa fa-pencil', 'value' => '登録');
		$link_list[] = array('url' => 'training_category/TrainingCategoryList/output', 'class' => 'fa fa-file-text', 'value' => '出力');
		
		return $link_list;
	}
}
?>