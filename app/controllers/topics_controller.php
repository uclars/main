<?php
class TopicsController extends AppController {

	var $name = 'Topics';
	var $helpers = array('Html', 'Form', 'NiceNumber');
	var $layout = "home";
	var $uses = array('Topic', 'User', 'Comment');

	function index(){
		//get all topics
		$params = array(
			'conditions' => array('Topic.deleted'=>0),
			'order' => array('created DESC')
		);

		$this->set('topics', $this->Topic->find('all', $params));

		$me_array = $this->Session->read('Auth.User');
		$me = $me_array['id'];

		//get following info
		$following_topic_list = array();

		//get the topics list
		$following_topic_list = $this->_getFollowingTopicList($me);
		$this->set('following_topic_list', $following_topic_list);

	}

	function show_topic() {
		$topic_id = $this->params['named']['topicid'];
		$this->set('topics', $this->Topic->find('all', array('conditions' => array('id' => $topic_id))));

		$me_array = $this->Session->read('Auth.User');
		$me = $me_array['id'];


		$params = array(
			'conditions' => array('Comment.deleted' => 0, 'Comment.topic_id' => $topic_id),
			'order' => array('created DESC')
		);
		$com = $this->Comment->find('all', $params);
		//$com = $this->Comment->find('all', array('conditions'=>array('topic_id'=>$topic_id, 'Comment.deleted' => 0)));
		$this->set('comments', $com);


		//get following info
		$following_topic_list = array();

		//get the topics list
		$following_topic_list = $this->_getFollowingTopicList($me);
		$this->set('following_topic_list', $following_topic_list);		


/*
echo("<PRE>");
var_dump($following_topic_list);
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


	function _getFollowingTopicList($userid){
		$following_topic_list = array();
		$topic_list = $this->requestAction(array(
				'controller' => 'followings',
				'action' => 'following_topic'
			));

		$i=0;
		foreach($topic_list as $tlist){
			$following_topic_list[$i]=$tlist['Following']['following_topic_id'];
			$i++;
		}

		return $following_topic_list;
	}
}
?>
