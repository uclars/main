<?php
//### CREATE 2010/06/20 Pyon ###
class HomeController extends AppController {

	var $components = array('Auth', 'Session');
	var $name = 'Home';
	var $helpers = array('Html', 'Form');
	var $layout = "home";
	var $uses = array('User', 'Post');

	//### アクションが実行される前に実行 ###
	function beforeFilter() {
		//親クラス呼出
		parent::beforeFilter();
		//[Auth]例外設定
		//$this->Auth->allow('*');
	}

	//### ホーム ###
	function index() {
		$this->set('posts', $this->Post->find('all'));
		$this->set('auth', $this->Session->read('Auth.User'));

		//put the posts the user following in array
		$following_post_list = array();
		$following_post_data = $this->requestAction('followings/following_post');
		$i=0;
		foreach($following_post_data as $fpdata){
                	$following_post_list[$i]=$fpdata['Following']['following_post_id'];
        	        $i++;
	        }
		$this->set('post_list', $following_post_list);
		
/*
echo("<PRE>");
var_dump($following_post_list);
echo("</PRE>");
*/

		//$post = $this->Post->find('id');
/*
		$this->Post->bindModel(array(
			'hasOne' => array(
				'User' => array(
					'className' => 'User',
					'foreignKey' => 'id',
					'fields' => 'User.username, User.profile_img'
				)
			)
		), false);
*/
//		$this->set('owner', $this->User->findById($post['Post']['id']));
		//投稿データセット
/*
		$this->Article->recursive = 0;
		$this->Article->bindModel(array(
			'hasOne' => array(
				'CommentArticle' => array(
					'className' => 'CommentArticle',
					'foreignKey' => 'article_id',
					'fields' => 'CommentArticle.Count',
					'type' => 'LEFT'
				)
			)
		), false);
*/
//		$this->paginate = array('order' => 'Article.id DESC');
//		$this->set('datas', $this->paginate(array('Article.deleted' => 0)));
		//重複登録対策(キー発行)
//		if ($this->Auth->user()) {
//			$this->data['Request']['id'] = AppController::_getRequestId();
//			if (strcmp($this->data['Request']['id'], '') == 0) {
//				//エラー画面出力
//				$this->set('code', '100');
//				$this->render('/errors/custom');
//			}
//		}
	}

}
?>
