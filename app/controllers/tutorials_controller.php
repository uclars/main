<?php
class TutorialsController extends AppController {

	var $components = array('Auth', 'Facebook.Connect', 'Session');
	var $name = 'Tutorials';
	var $helpers = array('Html', 'Form', 'NiceNumber');
	var $layout = "tutorial";
	var $uses = array('User', 'Topic', 'Comment');


	//### アクションが実行される前に実行 ###
	function beforeFilter() {
		//親クラス呼出
		parent::beforeFilter();
		//[Auth]例外設定
	//	$this->Auth->allow('index');

		$this->_checkPhase();
	}


	function _checkPhase(){
		$t_phase = "";
		$url_phase = "";
		$url_phase_sub = "";

		$t_phase = $this->Session->read('phase');
		$url_phase = $this->params['pass'][0];	
		if(!empty($this->params['pass'][1])){
			$url_phase_sub = $this->params['pass'][1];
		}

/*
echo "t".$t_phase."<br>";
echo "url".$url_phase."<br>";
echo "urlp".$url_phase_sub."<br>";
exit;
*/


		///if url tutorial number is different from tutorial num in session, redirect
		if($t_phase != $url_phase){
			$this->redirect(array('controller'=>'error'));
		}
	}

	//### ホーム ###
	function index() {
		$this->set('auth', $this->Session->read('Auth.User'));

		$this->Comment->recursive = 0;
		$params = array(
			'conditions' => array('Comment.deleted' => 0),
			'order' => array('created DESC')
		);
		$topics = $this->Comment->find('all', $params);
		$this->set('datas', $topics);


                //put the posts the user following in array
                $following_topic_list = array();
                $following_topic_data = $this->requestAction('followings/following_topic');
                $i=0;

		if($following_topic_data){
			foreach($following_topic_data as $fpdata){
				$following_topic_list[$i]=$fpdata['Following']['following_topic_id'];
				$i++;
			}	
			$this->set('topic_list', $following_topic_list);
		}
		else{
			$this->set('topic_list', '');
		}

/*
echo("<PRE>");
var_dump($following_topic_list);
echo("</PRE>");
exit;
*/


	}

	function phase(){
		$me_array = $this->Session->read('Auth.User');
		$me = $me_array['id'];
		$tutorial_num = ""; //tutorial num on url
		$tutorial_num_sub = ""; //tutorial sub num in which set session for the next phase on url, so that user can reload on the base($tutorial_num) page

		$tutorial_num = $this->params['pass'][0];
		if(!empty($this->params['pass'][1])){ // if tutorial sub num exists, set the num to the variable
			$tutorial_num_sub = $this->params['pass'][1];
		}

		$updateq = "update users set `tutorial`=? where `id`=".$me;
		switch($tutorial_num){
			case "10": //welcome page
				$this->set('phase', '10');

				if($tutorial_num_sub==1){
					$this->Session->write('phase', 20);
					$this->User->query($updateq, array(20));

					$this->redirect(array('action'=>'phase',20));
					return;
				}

				break;
			case "20": //follow the first topic
				$this->set('phase', 20);

				if($tutorial_num_sub==1){
					$this->Session->write('phase', 30);
					$this->User->query($updateq, array(30));
					$this->redirect(array('action'=>'phase',30));
					return;
				}

				//get all topics
				$params = array(
					'conditions' => array('Topic.deleted'=>0),
					'order' => array('created DESC')
				);

				$this->set('topics', $this->Topic->find('all', $params));

				break;
			case "30":
				$this->set('phase', 30);

				if($tutorial_num_sub==1){
					$this->Session->write('phase', 40);
					$this->User->query($updateq, array(40));
					$this->redirect(array('action'=>'phase',40));
					return;
				}

				break;
			case 40:
				$this->set('phase', 40);
				if($tutorial_num_sub==1){
					$this->Session->write('phase', 50);
					$this->User->query($updateq, array(50));
					$this->redirect(array('action'=>'phase',50));
					return;
				}

				break;
			case 50:
				$this->set('phase', 50);
				if($tutorial_num_sub==1){
					$this->requestAction('comments/add'); //write a new comment
					$this->Session->write('phase', 60);
					$this->User->query($updateq, array(60));
					$this->redirect(array('action'=>'phase',60));
					return;
				}

				break;

			case 60:
				$this->set('phase', 60);
				if($tutorial_num_sub==1){
					$new_nickname=$this->data['User']['body'];
					$this->_nickname($new_nickname, $me);
					$this->Session->write('phase', 70);
					$this->User->query($updateq, array(70));
					$this->redirect(array('action'=>'phase',70));
				}

				break;
			case 70:
				$this->set('phase', 70);
				if($tutorial_num_sub==1){
					$this->Session->write('phase', 80);
					$this->User->query($updateq, array(80));
					$this->redirect(array('action'=>'phase',80));
					return;
				}

				break;
			case 80:
				$this->set('phase', 80);
				if($tutorial_num_sub==1){
					$new_avator=$this->data['User']['avator'];
					$this->_avator($new_avator, $me);
					$this->Session->write('phase', 90);
					$this->User->query($updateq, array(90));
					$this->redirect(array('action'=>'phase',90));
					return;
				}

				break;

			case 90:
				$this->set('phase', 90);
				if($tutorial_num_sub==1){
					$this->Session->write('phase', 100);
					$this->User->query($updateq, array(100));
					$this->redirect(array('action'=>'phase',100));
					return;
				}

				break;
			case 100:
				$this->set('phase', 100);
				if($tutorial_num_sub==1){
					$endsql = "update users set `tutorial`=0 where `id`=".$me;
					$this->Session->delete('phase');
					$this->User->query($endsql);
					$this->redirect(array('controller'=>'home', 'action'=>'index'));
					return;
				}

				break;
		}

		$this->Comment->recursive = 0;
		if($tutorial_num>=55){ //after following the user
			$params = array(
				'conditions' => array('or' => array('Comment.topic_id'=>1,'User.id'=>41), 'Comment.deleted' => 0),
				'order' => array('created DESC')
			);
		}
		else{ //following the topic only
			$params = array(
				'conditions' => array('Comment.topic_id'=>1, 'Comment.deleted' => 0),
				'order' => array('created DESC')
			);
		}
		$comments = $this->Comment->find('all', $params);
		$this->set('datas', $comments);
	}


	function follows(){
		$follow_num = $this->params['pass'][0];

		switch($follow_num){
			case "1":
				$this->set('phase', 10);
				break;
			case "2":
				$this->set('phase', 20);
				break;
                }
	}

	function _nickname($newnickname, $me){
		///put the new nick name ///
		$query = "update users set username='".$newnickname."' where id=$me";
		$this->User->query($query);
	}

	function _avator($newavator, $me){
		uses('folder', 'file');
		//////////////////////////
		///  make the folder  ////
		//////////////////////////
		$newfold="/var/www/html/main/app/webroot/img/profile/".$me;
		$folder = new Folder($newfold);
		$folder->create($newfold, 0755);


		/////////////////////////
		///  makek the file /////
		/////////////////////////
		switch($newavator){
			case "0":
				$orgfile="/var/www/html/main/app/webroot/img/cake.icon.png";
				break;
			case "1":
				$orgfile="/var/www/html/main/app/webroot/img/cake.icon.png";
				break;

		}
		$newfile="/var/www/html/main/app/webroot/img/profile/".$me."/".$me.".png";

		$file = new File($orgfile);
		if($file->copy($newfile)){
			$image_path="/img/profile/$me/$me.png";
		}

		$query = "update users set `profile_img`='$image_path' where `id`=$me";
		$this->User->query($query);
	}
}
?>
