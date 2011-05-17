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
		$t_phase = $this->Session->read('phase');
		$url_phase = $this->params['pass'][0];	

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
		$tutorial_num = $this->params['pass'][0];

		switch($tutorial_num){
			case "1":
				$this->set('phase', 1);

				$this->Session->write('phase', 2);
				break;
			case "2":
				$this->set('phase', 2);

				//get all topics
				$params = array(
					'conditions' => array('Topic.deleted'=>0),
					'order' => array('created DESC')
				);

				$this->set('topics', $this->Topic->find('all', $params));

				break;

		}
	}


	function follows(){
		$follow_num = $this->params['pass'][0];

		switch($follow_num){
			case "1":
				$this->set('phase', 1);
				break;
			case "2":
				$this->set('phase', 2);
				break;
                }
	}
}
?>
