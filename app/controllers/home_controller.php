<?php
//### CREATE 2010/06/20 Pyon ###
class HomeController extends AppController {

	var $components = array('Auth', 'Facebook.Connect', 'Session');
	var $name = 'Home';
	var $helpers = array('Html', 'Form', 'NiceNumber');
	var $layout = "home";
	var $uses = array('User', 'Topic', 'Comment');


	//### アクションが実行される前に実行 ###
	function beforeFilter() {
		//親クラス呼出
		parent::beforeFilter();
		//[Auth]例外設定
		$this->Auth->allow('index');

		$this->_checkRegister();
		$this->_checkTutorial();
	}

	/// If username is null -> just registered user, redirect to the registration page
	function _checkRegister(){
		$user_array = $this->Session->read('Auth.User');

		$username = $user_array['username'];
		$userid = $user_array['id'];
		$first_time = $this->Session->read('firsttime');

		if($first_time){
			if(is_null($username)){
				$this->redirect(array("controller" => "users", "action" => "register", $userid));
			}
			else{


/*
		echo "<PRE>";
		var_dump($this->Session->read('Auth.User'));
		echo "</PRE>";
		exit;
*/

			}
		}
	}

	function _checkTutorial(){
		$user_array = $this->Session->read('Auth.User');
		$t_phase = $this->Session->read('phase');



		/// if you don't have tutorial phase in the session, call SQL
		if(empty($t_phase)){
			$params = array(
				'conditions' => array('User.id' => $user_array['id'])
			);
			$current_tutorial_array = $this->User->find('all', $params);

			// if anonymous user, donot redirect
			if(!empty($current_tutorial_array)){
				$current_tutorial = $current_tutorial_array[0]['User']['tutorial'];
				// if user has already finished tutorial, donot redirect
				if($current_tutorial!=0){
					$this->Session->write('phase', $current_tutorial_array[0]['User']['tutorial']);
					$this->redirect(array("controller" => "tutorials", "action" => "phase", $current_tutorial));
				}
			}
			return;
		}
		else{
			$this->redirect(array("controller" => "tutorials", "action" => "phase", $t_phase));
		}


	}


	//### ホーム ###
	function index() {
		//$this->set('auth', $this->Session->read('Auth.User'));

/*
		//put the posts the user following in array
		$following_topic_list = array();
		$following_topic_data = $this->requestAction('followings/following_topic');
		$i=0;
		foreach($following_topic_data as $fpdata){
                	$following_topic_list[$i]=$fpdata['Following']['following_topic_id'];
        	        $i++;
	        }
		$this->set('topic_list', $following_topic_list);
*/

		
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
					'fields' => 'User.id, User.username, User.profile_img'
				)
			)
		), false);
*/

//		$this->set('owner', $this->User->findById($post['Post']['id']));
		//投稿データセット

/*
		$this->Topic->recursive = 0;
		$this->Topic->bindModel(array(
			'hasOne' => array(
				'CommentTopic' => array(
					'className' => 'CommentTopic',
					'foreignKey' => 'topic_id',
					'fields' => 'CommentTopic.Count',
					'type' => 'LEFT'
				)
			)
		), false);
*/






/*
                $this->Topic->bindModel(array(
                        'hasOne' => array(
                                'Comment' => array(
                                        'className' => 'Comment',
                                        'foreignKey' => 'topic_id',
                                        'fields' => 'id, user_id, body, created',
                                        'type' => 'LEFT'
                                )
                        )
                ), false);


		$topics = $this->Topic->find('all', array('conditions' => array('Comment.deleted' => 0)));
*/

		$timeline_array=array();

		//paginate
		$this->Comment->recursive = 0;

                //put the posts the user following in array
                //$following_topic_list = array();
                $following_topic_list = "";
                $following_topic_data = $this->requestAction('followings/following_topic');
		////  condition array  * array[$j]['or'][$i]
		////                     array[$j]['and'][$num]
                $i=0; //numbers of 'or'
		$j=0; //numbers of 'or' and 'and'

		if($following_topic_data){
			foreach($following_topic_data as $fpdata){
				$condition[$j]['or'][$i] = array('Comment.topic_id'=>$fpdata['FollowingTopics']['following_topic_id']);
				$i++;
			}
		}


		//put a user the user following in array
                //$following_user_list = array();
                $following_user_list = "";
                $following_user_data = $this->requestAction('followings/following_user');

		if($following_user_data){
			foreach($following_user_data as $fudata){
				$condition[$j]['or'][$i] = array('Comment.user_id'=>$fudata['FollowingUsers']['following_user_id']);
				$i++;
			}	
		}
		$j++; //increment

		$condition[$j]['and'] = array(array('Comment.deleted'=>0));

		$this->paginate['conditions']=$condition;
		$this->paginate['order']='created';
		$this->set('timelines',$this->paginate('Comment'));
//		$this->set('timelines',$timeline_array);

/*
echo("<PRE>");
var_dump($timeline_array);
echo("</PRE>");
exit;
*/



//		$this->paginate = array('order' => 'Topic.id DESC');
//		$this->set('datas', $this->paginate(array('Topic.deleted' => 0)));
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
