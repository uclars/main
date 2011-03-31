<?php
class UsersController extends AppController
{
   var $components = array('Auth', 'Session');

   function beforeFilter() {
	parent::beforeFilter(); 
	$this->Auth->allow('add', 'login');

	//認証パラメータをusername -> emailに変更
	$this->Auth->fields = array(
		'username' => 'email',
		'password' => 'password'
	);
	//オリジナルの認証項目追加する場合
	//$this->Auth->userScope= array("lock"=>'false');

	$this->Auth->autoRedirect = false; //自動リダイレクトを無効
   }
 
	function home() {
//    		$this->checkSession();
    		$this->set('me', $this->User->findById($this->Session->read('my_id')));
	}

	function login() {
//		$this->set('error', false);

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
*/


/*
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

		$this->Session->write('Auth.User', $cookie);

		$this->redirect($this->Auth->redirect());

echo "sucess";
var_dump($cookie);


        }else{
            //ログイン失敗した時の処理
        }
    }



	}

   function logout() {
	$this->Auth->logout();
	$this->redirect('/home/');
   }

   function add() {
       if (!empty($this->data)) {
           $this->User->create();
           $this->User->save($this->data['User']);
           $this->redirect(array('action' => 'home'));
       }
   }

/*
   function save_hash($input_data) {
       $this->save($insert_data);
   }
*/

}
?>
