<?php

/**
 * 社内研修問題情報テーブル定義ファイル
 * @author takanori_gozu
 *
 */
class TrainingQuestionDao {
	
	const TABLE_NAME = 'training_question';
	
	const TRAINING_TYPE_PRIVACY = '1';  //Pマーク
	const TRAINING_TYPE_SECURITY = '2'; //セキュリティ
	
	const COL_ID = 'id';
	const COL_TRAINING_TYPE = 'training_type';
	const COL_QUESTION = 'question';
	const COL_ANSWER_LIST = 'answer_list';
	const COL_ANSWER = 'answer';
	const COL_POINT = 'point';
}
?>