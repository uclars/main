<?php
class TutorialsController extends AppController {

	var $components = array('Auth', 'Facebook.Connect', 'Session');
	var $name = 'Tutorials';
	var $helpers = array('Html', 'Form', 'NiceNumber', 'Session');
	var $layout = "tutorial";
	var $uses = array('User', 'Topic', 'Comment','MasterAvator');


	//### アクションが実行される前に実行 ###
	function beforeFilter() {
		//親クラス呼出
		parent::beforeFilter();
		//[Auth]例外設定
		$this->Auth->allow('*');

		$this->_checkPhase();
	}

	function _checkPhase(){
		$t_phase = "";
		$url_phase = "";
		$url_phase_sub = "";

		$t_phase = $this->Session->read('phase');
		$url_phase = $this->params['pass'][0];


/*
echo("<PRE>");
var_dump($t_phase);
var_dump($url_phase);
echo("</PRE>");
exit;
*/


		if(!empty($this->params['pass'][1])){
			$url_phase_sub = $this->params['pass'][1];
		}

		///if url tutorial number is different from tutorial num in session, redirect
		if($t_phase != $url_phase){
			$this->redirect(array('controller'=>'home'));
		}
	}

	function phase(){
		// Get User Info //
		$me_array = $this->Session->read('Auth.User');
		$me = $me_array['id'];
		$avator_number = $me_array['avator_num'];
		$birthday = $me_array['birthday'];

		$this->set('me_array', $me_array);

		// SIDEBAR SHOW //
		$this->set('sidebar', null); //if this is true, show the contents in the sidebar

		// Get Tutorial Num //
		$tutorial_num = ""; //tutorial num on url
		$tutorial_num_sub = ""; //tutorial sub num in which set session for the next phase on url, so that user can reload on the base($tutorial_num) page
		$tutorial_error = "";

		$tutorial_num = $this->params['pass'][0];
		if(!empty($this->params['pass'][1])){ // if tutorial sub num exists, set the num to the variable
			if($this->params['pass'][1]==1){
				$tutorial_num_sub = $this->params['pass'][1];
			}
			elseif($this->params['pass'][1]=='error'){
				$tutorial_error = $this->params['pass'][1];
			}
		}

		///////////////////////////////////////////
		// Set Variabes for each Tutorial Phase  //
		$updateq = "update users set `tutorial`=? where `id`=".$me;
		switch($tutorial_num){
			case "0": //welcome page
				$this->set('phase', '0');

				if(!is_null($me_array)){ //if the user is logged in
					$this->Session->write('phase', 10);
					$this->User->query($updateq, array(10));
					$this->redirect(array('action'=>'phase',10));
					return;
				}

				break;
			case 10: //follow the first topic
				$this->set('phase', '10');

				if($tutorial_num_sub==1){
					$this->Session->write('phase', 20);
					$this->User->query($updateq, array(20));
					$this->redirect(array('action'=>'phase',20));
					return;
				}

				//get all topics
				$params = array(
					'conditions' => array('Topic.deleted'=>0, 'Topic.hide'=>0),
					'order' => array('created ASC')
				);
				$this->set('topics', $this->Topic->find('all', $params));

				///contents for sidebar
				$this->set('sidebar', '10');

				break;
			case 20:  ///show the topic page with follow link
				$this->set('phase', 20);

				if($tutorial_num_sub==1){
					$this->Session->write('phase', 30);
					$this->User->query($updateq, array(30));
					$this->redirect(array('action'=>'phase',30));
					return;
				}

				$this->set('topics', $this->Topic->find('all', array('conditions' => array('Topic.id' => 1))));
				//pagenate for topic 1
				$this->paginate = array(
					'conditions' => array('Comment.deleted' => 0, 'Comment.hide' => 0,'Comment.topic_id' => 1),
					'limit' => 500,
					'order' => array('Comment.created desc')
				);
				$this->set('comments',$this->paginate('Comment'));

				///contents for sidebar
				$this->set('sidebar', '20');

				break;
			case 30: //follow the first topic
				$this->set('phase', 30);

				if($tutorial_num_sub==1){
					$this->Session->write('phase', 60);
					$this->User->query($updateq, array(60));
					$this->redirect(array('action'=>'phase',60));
					return;
				}

				//get first topics
				$params = array(
					'conditions' => array('Topic.deleted'=>0, 'Topic.hide'=>0,'Topic.id'=>1),
					'order' => array('created ASC')
				);
				$this->set('first_topic', $this->Topic->find('first', $params));

				///contents for sidebar
				$this->set('sidebar', '30');

				break;
			case 60: //Set NICK NAME
				$this->set('phase', 60);

				if($tutorial_num_sub==1){
					$new_nickname=$this->data['User']['body'];
					$this->_nickname($new_nickname, $me);
					$this->Session->write('nick_name', $new_nickname);
					$me_array['username'] = $new_nickname;
					$this->_setAge($birthday, $me);
					$this->Session->write('nick_name', $new_nickname);
					$this->Session->write('Auth.User', $me_array);
					$this->Session->write('phase',70);
					$this->User->query($updateq, array(70));
					$this->redirect(array('action'=>'phase',70));
				}

				/// username is already registered
				if($tutorial_error == "error"){
					$this->set('error_mssg', 'The user name is alreday registered. Please input another name.<br />');
				}

				///contents for sidebar
				$this->set('sidebar', '60');

				break;
			case 70: ///Welcome page
				$this->set('phase', 70);

				if($tutorial_num_sub==1){
					$this->Session->write('phase', 90);
					$this->User->query($updateq, array(90));
					$this->redirect(array('action'=>'phase',90));
					return;
				}

				//get my name
				$this->set('username', $me_array['username']);

				///contents for sidebar
				$this->set('sidebar', '70');

				break;
			case 90: ///ADD a Comment
				$this->set('phase', 90);

				if($tutorial_num_sub==1){
					$this->requestAction('comments/add'); //write a new comment
					$this->Session->write('phase', 100);
					$this->User->query($updateq, array(100));
					$this->redirect(array('action'=>'phase',100));
					return;
				}

				$this->set('topics', $this->Topic->find('all', array('conditions' => array('Topic.id' => 1))));
				//pagenate for topic 1
				$this->paginate = array(
					'conditions' => array('Comment.deleted' => 0, 'Comment.hide' => 0,'Comment.topic_id' => 1),
					'limit' => 500,
					'order' => array('Comment.created desc')
				);
				$this->set('comments',$this->paginate('Comment'));

				///contents for sidebar
				$this->set('sidebar', '90');

				break;
			case 100: //Show the comment page
				$this->set('phase', 100);

				if($tutorial_num_sub==1){
					$endsql = "update users set `tutorial`=0 where `id`=".$me;
					$this->Session->delete('phase');
					$this->Session->write('t_finish',1);
					$this->User->query($endsql);
					$this->redirect(array('controller'=>'home', 'action'=>'index'));
					return;
				}

				$this->set('topics', $this->Topic->find('all', array('conditions' => array('Topic.id' => 1))));
				//pagenate for topic 1
				$this->paginate = array(
					'conditions' => array('Comment.deleted' => 0, 'Comment.hide' => 0, 'Comment.topic_id' => 1),
					'limit' => 500,
					'order' => array('Comment.created desc')
				);
				$this->set('comments',$this->paginate('Comment'));

				///contents for sidebar
				$this->set('sidebar', '100');
					
				break;
		}

	}

	function _nickname($newnickname, $me){
		///check if the new nick name is already used ///
		$params = array(
			'conditions' => array('User.username'=>$newnickname),
		);
		$user_check = $this->User->find('first', $params);

		if($user_check){ //if the username is already registered
			 $this->redirect(array("controller"=>"tutorials","action"=>"phase",60,"error"));
		}
		else{
			///put the new nick name ///
			$query = "update users set username='".$newnickname."' where id=$me";
			$this->User->query($query);
		}
	}

	function _setAge($birthday, $me){
		$age = (int)((date('Ymd')- date('Ymd',strtotime($birthday)))/10000);

		// get avator num depending on age
		if($age>=10 && $age<20){
			$newavator = 0;
		}
		else if($age>=20 && $age<25){
			$newavator = 1;
		}
		else if($age>=25 && $age<30){
			$newavator = 2;
		}
		else if($age>=30 && $age<35){
			$newavator = 3;
		}
		else if($age>=35 && $age<40){
			$newavator = 4;
		}
		else if($age>=40 && $age<50){
			$newavator = 5;
		}
		else if($age>=50 && $age<60){
			$newavator = 6;
		}
		else{}

		/// set avator
		$this->_avator($newavator, $me);

		return;
	}

	function _avator($newavator, $me){
		switch($newavator){
			case "0":
				$ava_num=1;
				break;
			case "1":
				$ava_num=2;
				break;
			case "2":
				$ava_num=3;
				break;
			case "3":
				$ava_num=4;
				break;
			case "4":
				$ava_num=5;
				break;
			case "5":
				$ava_num=6;
				break;
			case "6":
				$ava_num=7;
				break;
		}

		/// Insert into the DB
		$query = "update users set `avator_num`='$ava_num' where `id`=$me";
		$this->User->query($query);

		return $ava_num;
	}
}
?>
