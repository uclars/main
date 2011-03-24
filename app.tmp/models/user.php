<?php
//### CREATE 2010/06/20 Pyon ###
class User extends AppModel {

	var $name = 'User';
	var $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => '表示名を入力してください。',
				'last' => true
			),
			'maxLength' => array(
				'rule' => array('maxLength', 32),
				'message' => '表示名は32文字以内で入力してください。'
			)
		),
		'username' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'ログイン名を入力してください。',
				'last' => true
			),
			'alphaNumeric' => array(
				'rule' => array('custom', '/^[A-Za-z0-9\-_.]*$/i'),
				'message' => 'ログイン名は半角英数字と記号(ハイフン「-」アンダーバー「_」ドット「.」のみ)で入力してください。',
				'last' => true
			),
			'minLength' => array(
				'rule' => array('minLength', 3),
				'message' => 'ログイン名は3文字以上入力してください。',
				'last' => true
			),
			'maxLength' => array(
				'rule' => array('maxLength', 32),
				'message' => 'ログイン名は32文字以内で入力してください。',
				'last' => true
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'このログイン名は使用できません。'
			)
		),
		'password_new' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'on' => 'create',//【INSERT時のみチェック】
				'message' => 'パスワードを入力してください。',
				'last' => true
			),
			'alphaNumeric' => array(
				'rule' => array('custom', '/^[!-~]*$/i'),
				'allowEmpty' => true,//【空以外の時のみチェック】
				'message' => 'パスワードは半角英数字と記号で入力してください。',
				'last' => true
			),
			'minLength' => array(
				'rule' => array('minLength', 6),
				'allowEmpty' => true,//【空以外の時のみチェック】
				'message' => 'パスワードは6文字以上入力してください。',
				'last' => true
			),
			'maxLength' => array(
				'rule' => array('maxLength', 32),
				'message' => 'パスワードは32文字以内で入力してください。'
			)
		),
		'password_chk' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'on' => 'create',//【INSERT時のみチェック】
				'message' => 'パスワード(再入力)を入力してください。',
				'last' => true
			),
			'sameCheck' => array(
				'rule' => array('sameCheck', 'password_new'),
				'message' => 'パスワード(再入力)がパスワードと異なります。'
			)
		)
	);

}
?>