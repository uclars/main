<?php
class CommentsController extends AppController {

	var $name = 'Comments';
	var $helpers = array('Html', 'Form');
	var $layout = 'home';

/*
	//### アクションが実行される前に実行 ###
	function beforeFilter() {
		//親クラス呼出
		parent::beforeFilter();
		//[Auth]例外設定
		$this->Auth->allow('*');
	}
*/


	function index() {
		$this->set('comments', $this->Post->find('all'));
	}

	function add() {

		$comment_id = "";
		$topic_id = "";
		if(!empty($this->params['named'])){
			$comment_id = $this->params['named']['cid'];
			$topicid = $this->params['named']['topicid'];
		}


/*
echo "<PRE>";
var_dump($this->params);
echo "</PRE>";
exit;
*/


		if(!empty($this->data)) {
			if($this->Comment->save($this->data, true, array('user_id', 'topic_id', 'body'))) {
				$this->flash('Your posts have been saved','/posts');
				return;
			}
		}
		else if(!empty($comment_id)){

			$params = array(
				'conditions' => array('Comment.id'=>$comment_id),
			);

			$target_comment = $this->Comment->find('all', $params);
			$this->set('target_comment', $target_comment[0]['Comment']['body']);
			$this->set('topic_id', $topicid);



/*
echo "<PRE>";
var_dump($target_comment[0]['Comment']['body']);
echo "</PRE>";
exit;
*/



			return;

		}
		else{
			$this->redirect('/home');
		}
	}

	function action(){
                $id = $this->params['named']['id'];
                $do = $this->params['named']['do'];

                switch($do){
                        case "follow":
                                $me = $this->Session->read('Auth.User');
                                $this->_follow_user($me['id'], $id);
                                $msg = "You have followed a user!";
                        break;

                        case "unfollow":
                                $me = $this->Session->read('Auth.User');
                                $this->_unfollow_user($me['id'], $id);
                                $msg = "You have unfollowed a user!";
                        break;
                }
                $this->Session->write('msg', $msg);

                $this->redirect('/');
        }


}
?>
