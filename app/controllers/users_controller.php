<?php
class UsersController extends AppController
{
	var $components = array('Auth', 'Facebook.Connect', 'Session');
	var $name = 'Users';
	var $helpers = array('Html', 'Form', 'NiceNumber');
	var $layout = "home";


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




	$this->User->recursive=0;
	$user_list = $this->User->find('all');

	//put the followers who are followed by clicked id in array
	$follower_list = array();
	$follower_data = $this->requestAction(array('controller' => 'followings', 'action' => 'following_user'), array('userid' => $id));
	$i=0;
	foreach($follower_data as $fdata){
		$follower_list[$i]=$fdata['Following']['following_user_id'];
		$i++;
	}

	//put the my(logged in user) followers
	$my_follower_list = array();
	$my_follower_data = $this->requestAction(array('controller' => 'followings', 'action' => 'following_user'), array('userid' => $me));
	$j=0;
	foreach($my_follower_data as $mfdata){
		$my_follower_list[$j]=$mfdata['Following']['following_user_id'];
		$j++;
	}

	$this->set('user_list', $user_list);
	$this->set('follower_list', $follower_list);
	$this->set('my_follower_list', $my_follower_list);
   }
}
?>
