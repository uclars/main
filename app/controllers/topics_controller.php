<?php
class TopicsController extends AppController {

	var $name = 'Topics';
	var $helpers = array('Html', 'Form', 'NiceNumber');
	var $layout = "home";
	var $uses = array('Topic', 'User', 'Comment');


	function index() {
		$topic_id = $this->params['named']['topicid'];
		$this->set('topics', $this->Topic->find('all', array('conditions' => array('id' => $topic_id))));
		$params = array(
			'conditions' => array('Comment.deleted' => 0, 'Comment.topic_id' => $topic_id),
			'order' => array('created DESC')
		);
		$com = $this->Comment->find('all', $params);
		//$com = $this->Comment->find('all', array('conditions'=>array('topic_id'=>$topic_id, 'Comment.deleted' => 0)));
		$this->set('comments', $com);


/*
echo("<PRE>");
var_dump($com);
echo("</PRE>");
exit;
*/



	}

	function view($id) {
		$this->Topic->id=$id;
		$this->set('topic', $this->Topic->read());
	}

	function add() {
		if(!empty($this->data)) {
			if($this->Topic->save($this->data, true, array('body'))) {
				$this->flash('Your topic have been saved','/posts');
				return;
			}
		}
		$this->redirect('/home');
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
