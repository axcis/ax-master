<?php

/**
 * DocumentCategoryListModel
 * @author takanori_gozu
 *
 */
class DocumentCategoryListModel extends MY_Model {
	
	/**
	 * 一覧
	 */
	public function get_list() {
		
		$this->set_table(DocumentCategoryDao::TABLE_NAME, 'master');
		
		$this->add_select(DocumentCategoryDao::COL_ID);
		$this->add_select(DocumentCategoryDao::COL_CATEGORY_NAME);
		
		return $this->do_select();
	}
	
	/**
	 * 項目名
	 */
	public function get_list_col() {
		
		$list_col = array();
		
		$list_col[] = array('width' => 70, 'value' => ''); //編集
		$list_col[] = array('width' => 150, 'value' => 'ID');
		$list_col[] = array('width' => 350, 'value' => 'カテゴリ名');
		
		return $list_col;
	}
	
	/**
	 * リンク
	 */
	public function get_link_list() {
		
		$link_list = array();
		
		$link_list[] = array('url' => 'document_category/DocumentCategoryRegist/regist_input', 'class' => 'fa fa-pencil', 'value' => '登録');
		$link_list[] = array('url' => 'document_category/DocumentCategoryList/output', 'class' => 'fa fa-file-text', 'value' => '出力');
		
		return $link_list;
	}
}
?>