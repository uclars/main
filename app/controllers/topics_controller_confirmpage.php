<?php
class TopicsController extends AppController {

	var $name = 'Topics';
	var $helpers = array('Html', 'Form', 'NiceNumber');
	var $layout = "topic";
	var $uses = array('Topic', 'User', 'Comment');
	var $components = array('Logincheck');

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
		$topic_array = $this->Topic->find('all', array('conditions' => array('Topic.id' => $topic_id)));
		$this->set('topics', $topic_array);


		//get picture of topic owner
		$topic_array = $this->User->find('all', array('conditions' => array('User.id' => $topic_array[0]['Topic']['user_id'])));
		$this->set('topic_user_pic', $topic_array);


		$me_array = $this->Session->read('Auth.User');
		$me = $me_array['id'];

		//pagenate
		$this->paginate = array(
			'conditions' => array('Comment.deleted' => 0, 'Comment.topic_id' => $topic_id),
			'limit' => 200,
			'order' => array('User.tpoint desc', 'Comment.created asc')
		);
		$this->set('comments',$this->paginate('Comment'));	



/*
		$params = array(
			'conditions' => array('Comment.deleted' => 0, 'Comment.topic_id' => $topic_id),
			'order' => array('created DESC')
		);
		$com = $this->Comment->find('all', $params);

		//$com = $this->Comment->find('all', array('conditions'=>array('topic_id'=>$topic_id, 'Comment.deleted' => 0)));
		$this->set('comments', $com);
*/


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

	function topiccatlist(){
		$me_array = $this->Session->read('Auth.User');
		$me = $me_array['id'];
//		$this->set('me', $me);

		//get topic list for the specific category
		$topic__category_id = $this->params['named']['catid'];
		$params = array(
			'conditions' => array('Topic.deleted'=>0, 'Topic.category'=>$topic__category_id),
			'order' => array('created DESC')
		);
		$this->set('topic_cat', $this->Topic->find('all', $params));


		//get following info
		$following_topic_list = array();

		//get the topics list
		$following_topic_list = $this->_getFollowingTopicList($me);
		$this->set('following_topic_list', $following_topic_list);
	}

	function view($id) {
		//$this->Topic->id=$id;
		//$this->set('topic', $this->Topic->read());
	}

	function create() {
		$this->render('create','topiccreate'); //change layout for create
		$_POST['mode']="confirm";
		if(!empty($this->data)){
			if($_POST['mode'] == 'confirm'){
				//if(!$this->User->validates($this->data))　<=　こうしてみたけどダメだった・・・
				if($this->Topic->create($this->data) && $this->Topic->validates()){
					$this->set("topics",$this->data);
					$this->render("/topics/confirm");
				}else{
var_dump($this->Topic->invalidFields());
					$this->render();	
				}
			}else{
				$data = array();
				$data['title'] = $this->data['Topic']['title'];
				$data['body'] = $this->data['Topic']['body'];

				if($this->Topic->save($data)){
					$this->redirect('/');
				}else{
var_dump($data);
					//登録できなかった時はここよ！
				}
			}
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


	function _getFollowingTopicList($userid){
		$following_topic_list = array();
		$topic_list = $this->requestAction(array(
				'controller' => 'followings',
				'action' => 'following_topic'
			));

		$i=0;


		if(!is_null($topic_list)){
			foreach($topic_list as $tlist){
				$following_topic_list[$i]=$tlist['FollowingTopics']['following_topic_id'];
				$i++;
			}
		}

		return $following_topic_list;
	}
}
?>
