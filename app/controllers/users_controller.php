<?php
class UsersController extends AppController
{
	var $components = array('Auth', 'Facebook.Connect', 'Session');
	var $name = 'Users';
	var $helpers = array('Html', 'Form', 'NiceNumber');
	var $layout = "home";
	var $uses = array('User', 'Topic', 'Comment');


   function beforeFilter() {
	parent::beforeFilter(); 
	$this->Auth->allow('add', 'login');

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
*/



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
	}

	function logout() {
		$this->Auth->logout();
		$this->Session->destroy();
		$this->redirect('/home/');
	}

	function register() {
/*
		/// haven't input a nickname
		if(!empty($this->params['pass'][0])) {
			$this->set('userid', $this->params['pass'][0]);
			return;
		}
*/
		$first_time = $this->Session->read('firsttime');

		if(!empty($first_time)){

			/// input a nickname
			if(!empty($this->params['data']['User']['username'])) {
				$id_array = $this->Session->read('Auth.User');
				$nickname = $this->params['data']['User']['username'];
				$this->Session->write('nick_name', $nickname);
				$check_existance = $this->User->find(array('username'=>$nickname));

				if(!$check_existance){
					$id = $this->Session->read('Auth.User');
	
					$data = array();
					$data['User']['id'] = $id_array['id'];
					$data['User']['username'] = $nickname;
					$data['User']['profile_img'] = '/img/profile/'.$nickname.'.png';
					$fields = array('username', 'profile_img');
					$this->User->save($data, false, $fields);

					$user_array = $this->Session->read('Auth.User');
					$user_array['username'] = $nickname;
					$this->Session->write('Auth.User', $user_array);
					$this->Session->delete('firsttime');
					$this->redirect('/home');
/*
echo"<PRE>";
var_dump($this->Session->read('firsttime'));
echo"</PRE>";
exit;
*/

				}
				else{ //nickname is already taken 
					$this->redirect(array('action'=>'register', $id_array['id']));
				}
				return;

			}
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

		$t_user = $this->User->find(array('id'=>$id));
		$this->set('target_user', $t_user);



/*
echo("<PRE>");
var_dump($me);
echo("</PRE>");
*/



		/// get Following info  ///
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
		///                   ////


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

	function _getFollowerList($id){
		//put the followers who are followed by clicked id in array
		$follower_list = array();
		$follower_data = $this->requestAction(array(
				'controller' => 'followings', 
				'action' => 'following_user'
			), array('userid' => $id));
	        $i=0;
		foreach($follower_data as $fdata){
			$follower_list[$i]=$fdata['Following']['following_user_id'];
			$i++;
        	}

		return $follower_list;
	}   

	function _getTopics($id){
		$params = array(
			'conditions' => array('Topic.user_id'=>$id, 'Topic.deleted'=>0),
		);
		$target_topic = $this->Topic->find('all', $params);

		return $target_topic;
	}

	function _getComments($id){
		$params = array(
			'conditions' => array('Comment.user_id'=>$id, 'Comment.deleted'=>0),
		);
		$target_comment = $this->Comment->find('all', $params);

		return $target_comment;
	}
}
?>
