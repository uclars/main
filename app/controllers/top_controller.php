<?php
class TopController extends AppController {

	var $components = array('Auth', 'Session');
	var $name = 'Top';
	var $helpers = array('Html', 'Form');
	var $layout = "home";
	var $uses = array('User', 'Post');

	//### アクションが実行される前に実行 ###
	function beforeFilter() {
		//親クラス呼出
		parent::beforeFilter();
		//[Auth]例外設定
		$this->Auth->allow('*');
	}

	//### ホーム ###
	function index() {
		$my_auth = $this->Session->read('Auth.User');
		if($my_auth)
		{
			$this->redirect('/home/');	
		}
		$this->set('posts', $this->Post->find('all'));

/*
echo "<PRE>";
var_dump($post);
echo "</PRE>";
*/
	}
}
?>
