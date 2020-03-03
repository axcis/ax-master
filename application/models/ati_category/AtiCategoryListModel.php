<?php

/**
 * AtiCategoryListModel
 * @author takanori_gozu
 *
 */
class AtiCategoryListModel extends MY_Model {
	
	/**
	 * 一覧
	 */
	public function get_list() {
		
		$this->set_table(AtiCategoryDao::TABLE_NAME, 'master');
		
		$this->add_select(AtiCategoryDao::COL_ID);
		$this->add_select(AtiCategoryDao::COL_CATEGORY_NAME);
		$this->add_select(AtiCategoryDao::COL_CATEGORY_DETAIL);
		
		return $this->do_select();
	}
	
	/**
	 * 項目名
	 */
	public function get_list_col() {
		
		$list_col = array();
		
		$list_col[] = array('width' => 70, 'value' => ''); //編集
		$list_col[] = array('width' => 70, 'value' => 'ID');
		$list_col[] = array('width' => 150, 'value' => 'カテゴリ名');
		$list_col[] = array('width' => 300, 'value' => '説明文');
		
		return $list_col;
	}
	
	/**
	 * リンク
	 */
	public function get_link_list() {
		
		$link_list = array();
		
		$link_list[] = array('url' => 'ati_category/AtiCategoryRegist/regist_input', 'class' => 'fa fa-pencil', 'value' => '登録');
		$link_list[] = array('url' => 'ati_category/AtiCategoryList/output', 'class' => 'fa fa-file-text', 'value' => '出力');
		
		return $link_list;
	}
}
?>