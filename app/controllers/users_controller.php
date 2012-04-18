<?php
class UsersController extends AppController
{
	var $components = array('Auth', 'Facebook.Connect', 'Session');
	var $name = 'Users';
	var $helpers = array('Html', 'Form', 'NiceNumber', 'Session');
	var $layout = "user";
	var $uses = array('User', 'Topic', 'Comment');


   function beforeFilter() {
	parent::beforeFilter(); 
	/*$this->Auth->allow('add', 'login');*/
	$this->Auth->allow('*');

	/*
	//認証パラメータをusername -> emailに変更
	$this->Auth->fields = array(
		'username' => 'email',
		'password' => 'password'
	);
	//オリジナルの認証項目追加する場合
	$this->Auth->userScope= array("lock"=>'false');
	*/

	$this->Auth->autoRedirect = false; //自動リダイレクトを無効
   }


	function home() {
//    		$this->checkSession();
//    		$this->set('me', $this->User->findById($this->Session->read('my_id')));
	}





	function login() {
		/// get topic title for facebook like display on facebook wall
		$topic_title = $this->Session->read('title');
		$this->set('title',$topic_title);

//		$this->redirect('/');

		$this->set('error', false);
/*
		if(empty($this->data)){
			if($this->Auth->user()){
				$this->set('msg', 'Already logged in');
				$this->render('/errors/custom');
			}
		}
		elseif($this->Auth->user()){
			if($this->Auth->user('deleted') != 0){
				$this->Session->setFlash('ID or password is wrong');
				$this->redirect($this->Auth->logout());
			}
			else{
				if($this->Session->check('Auth.redirect')){
					$redir=$this->Session->read('Auth.redirect');
					$this->Session->delete('Auth.redirect');
					$this->redirect(((strcmp(substr($redir, -6), '/login')==0) || (strcmp(substr($redir, -7), '/logout')==0)) ? '/' : $redir);
				}
				else{
					$this->redirect('/');
				}
			}
		}

		if (!empty($this->data)){
			$someone = $this->User->findByEmail($this->data['User']['email']);

			if(!empty($someone['User']['password']) && $someone['User']['password'] == $this->data['User']['password']){
				$this->Session->write('my_id', $someone['User']['id']);
//				$this->redirect('/users/home');
				$this->redirect('/');
			}
			else{
				$this->set('error', true);
			}
		}

		if($this ->data){    
			$user = $this->Auth->user();    
			if(!empty($user)){
				//ログインに成功した時の処理
				// Grab the data from the User table and set them to the cookie array
				$cookie = array();
				$cookie['id'] = $this->Auth->user('id');
				$cookie['email'] = $this->Auth->user('email');
				$cookie['username'] = $this->Auth->user('username');

				$this->Session->write('Auth.User', $cookie);

				$this->redirect($this->Auth->redirect('/'));
			}else{
				//ログイン失敗した時の処理
			}
		}
*/

	}

	function logout() {
		$this->Auth->logout();
		$this->Session->destroy();
		$this->redirect('/');
	}

	function register() {
/*
		/// haven't input a nickname
		if(!empty($this->params['pass'][0])) {
			$this->set('userid', $this->params['pass'][0]);
			return;
		}
*/
		$phase_num = $this->Session->read('phase');
		$first_time = $this->Session->read('firsttime');
		if(!empty($first_time)){
			$this->Session->write('phase', 10);
			 $this->redirect(array("controller" => "tutorials", "action" => "phase", 10));
/*
			/// input a nickname
			if(!empty($this->params['data']['User']['username'])) {
				$facebook_array = $this->Session->read('Auth.User');
				$nickname = $this->params['data']['User']['username'];
				$check_existance = $this->User->find(array('username'=>$nickname));

				if(!$check_existance){
					$id_array =  $this->User->findbyFacebookId($facebook_array['facebook_id']);

					$data = array();
					$data['User']['id'] = $id_array['User']['id'];
					$data['User']['username'] = $nickname;
					$data['User']['profile_img'] = '/img/profile/'.$nickname.'.png';
					$fields = array('username', 'profile_img');
					$this->User->save($data, false, $fields);

					$user_array = $this->Session->read('Auth.User');
					$user_array['id'] = $id_array['User']['id'];
					//$user_array['username'] = $nickname;
					$user_array['username'] = NULL;
					$this->Session->write('Auth.User', $user_array);
					$this->Session->write('phase', 10);
					$this->Session->delete('firsttime');
					$this->redirect('/');
				}
				else{ //nickname is already taken 
					$this->redirect(array('action'=>'register', $id_array['id']));
				}
				return;
			}
*/

		}
		else{
echo $first_time;
echo "lhl";
exit;
		}
	}

	function add() {
		if($this->Auth->user()){
			$this->set('msg', 'Already registered');
			$this->render('/errors/custom');
		}
		if(!empty($this->data)) {
			//input check
			$data = array();
			$data['User']['username'] = $this->data['User']['username'];
			$data['User']['email'] = $this->data['User']['email'];
			$data['User']['password_new'] = $this->data['User']['password_new'];
			$data['User']['password_chk'] = $this->data['User']['password_chk'];
			$this->User->create($data);
			if(!($this->User->validates())){
				$this->Session->setFlash('Something wrong!');
			}
			else{
				unset($data['User']['password_new']);
				unset($data['User']['password_chk']);
				$data['User']['password'] = $this->Auth->password($this->data['User']['password_new']);
				$this->User->save($data);
				//$this->redirect('/');
			}
		}
	}



	function show_users(){
		$id = $this->params['named']['id'];
		$me_array = $this->Session->read('Auth.User');
		$me = $me_array['id'];
		$this->set('username', $me_array['username']);

		if($id==$me){
			$this->User->recursive = 2;
			$t_user = $this->User->find(array('User.id'=>$id));
			$this->set('target_user', $t_user);
		}
		else{
			$this->redirect($this->referer());
		}


/*
$p_user = $this->User->find();
echo("<PRE>");
var_dump($id);
echo("</PRE>");
exit;
*/


		/*/// get Following info  ///
		$this->User->recursive=0;
		$user_list = $this->User->find('all');

		$follower_list = array();
		$my_follower_list = array();

		// get follower's list for the user you are watching, and your followers
		$follower_list = $this->_getFollowerList($id);
		$my_follower_list = $this->_getFollowerList($me);

		$this->set('user_list', $user_list);
		$this->set('follower_list', $follower_list);
		$this->set('my_follower_list', $my_follower_list);
		///                   ////*/


		//$topic_array = $this->requestAction("topics/getFollowingTopicList/$id"); //get following topics

		//$topic_array = $this->requestAction(array(
		//	'controller' => 'followings',
		//	'action' => 'following_topic'
		//));
		$topic_array = $this->_getFollowingTopics($id);
		$this->set('following_topics', $topic_array);


/*
echo("<PRE>");
var_dump($topic_array);
echo("</PRE>");
exit;
*/



		/// get target user topics   ///
		$target_topics = array();
		if(!empty($id)){
			$target_topics = $this->_getTopics($id);
		}
		$this->set('target_topics', $target_topics);
		///                  ///

		/// get target user comments ///
		$target_comments = array();
		if(!empty($id)){
			$target_comments = $this->_getComments($id);
		}
		$this->set('target_comments', $target_comments);
	}

	function _getFollowingTopics($id){
		$topic_array = array(); 
		App::import('Model', 'FollowingTopics');
		$this->FollowingTopics = new FollowingTopics();
		$conditions = array('FollowingTopics.user_id' => $id, 'FollowingTopics.deleted' => 0, 'NOT'=>array('FollowingTopics.following_topic_id'=>NULL));
		//$fields = array('DISTINCT FollowingTopics.following_topic_id');
		$fields = array();
		$order = array('FollowingTopics.id DESC');
		$following_topic = $this->FollowingTopics->find('all', array('conditions' => $conditions, 'fields'=>$fields, 'order' => $order));
		

		return $following_topic;

/*
echo "<PRE>";
var_dump($following_topic);
echo "</PRE>";
exit;
*/

	}

	function _getFollowerList($id){
		//put the followers who are followed by clicked id in array
		$follower_list = array();
		$follower_data = $this->requestAction(array(
				'controller' => 'followings', 
				'action' => 'following_user'
			), array('userid' => $id));
	        $i=0;



/*
echo("<PRE>");
var_dump($follower_data);
echo("</PRE>");
exit;
*/


		if(!empty($follower_data)){
			foreach($follower_data as $fdata){
				$follower_list[$i]=$fdata['FollowingUsers']['following_user_id'];
				$i++;
       		 	}
		}

		return $follower_list;
	}   

	function _getTopics($id){
		$params = array(
			'conditions' => array('Topic.user_id'=>$id, 'Topic.deleted'=>0, 'Topic.hide'=>0),
		);
		$target_topic = $this->Topic->find('all', $params);

		return $target_topic;
	}

	function _getComments($id){
		$params = array(
			'conditions' => array('Comment.user_id'=>$id, 'Comment.deleted'=>0),
			'order' => array('created DESC')
		);
		$target_comment = $this->Comment->find('all', $params);

		return $target_comment;
	}
}
?>
