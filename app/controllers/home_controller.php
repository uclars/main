<?php
class HomeController extends AppController {

	var $name = 'Home';
	var $helpers = array('Html', 'Form', 'NiceNumber', 'Session');
	var $layout = "home";
	var $uses = array('User', 'Topic', 'Comment', 'Comment_topic', 'Blacklist');
	var $components = array('Auth', 'Facebook.Connect', 'Session', 'Blacklists');


	//### アクションが実行される前に実行 ###
	function beforeFilter() {
		//親クラス呼出
		parent::beforeFilter();
		//[Auth]例外設定
		$this->Auth->allow('*');
		//$this->Auth->allow('index');
		$this->Blacklists->checkBlacklist();

		$this->_checkTutorial();

		//$this->_checkAge();
	}

/*
	/// If username is null -> just registered user, redirect to the registration page
	function _checkRegister(){
		$user_array = $this->Session->read('Auth.User');
	}
*/

	function _checkTutorial(){
		$user_array = $this->Session->read('Auth.User');
		$t_phase = $this->Session->read('phase');
		$t_finish = $this->Session->read('t_finish');

		/// if you don't have tutorial phase in the session, call SQL
		if(empty($t_phase)){
			// if anonymous user, donot redirect
			if(!empty($user_array)){
				$current_tutorial = $user_array['tutorial'];
				// if user has already finished tutorial, donot redirect
				if($current_tutorial!=0 and $t_finish != 1){
					$this->Session->write('phase', $current_tutorial);
					$this->redirect(array("controller" => "tutorials", "action" => "phase", $current_tutorial));
				}
			}
			return;
		}
		else{
			$this->redirect(array("controller" => "tutorials", "action" => "phase", $t_phase));
		}


	}

/*
	function _checkAge(){
		$user_array = $this->Session->read('Auth.User');
		if(!empty($user_array)){ //if the user is not registgered yet, don't do below
			$newage = (int)((date('Ymd')- date('Ymd',strtotime($user_array['birthday'])))/10000);
			$dbage = (int)((date('Ymd')- date('Ymd',strtotime($user_array['birthday'])))/10000);

			if($newage!=$dbage){
				
			}
		}
		//exit;
		return;		
	}
*/

	function redir(){
		var_dump($this->Session->read('Auth.User'));
exit;
		$this->redirect(array("controller" => "home", "action" => "index"));
	}
	
	//### ホーム ###
	function index() {
		$this->set('auth', $this->Session->read('Auth.User'));
		//$this->set('invite', INVITE);

		//For the Facebook "like" button
		//show the topic name in the browsr title
		//Session is made in the topic controller
		if($this->Session->read('title')){
			$topic_title = $this->Session->read('title');
			$this->set('title',$topic_title);
			$this->Session->delete('title');
		}

		//paginate
		$this->Comment->recursive = 0;

		// get date (today and a week from today)
		$start_date = gmdate("Y/m/d",strtotime("-8 week"));
		$end_date = gmdate("Y/m/d H:i:s");
		$tcondition = array('Topic.deleted'=>0, 'Topic.hide'=>0, 'Topic.created >=' => $start_date, 'Topic.created <=' => $end_date);
		$this->paginate['conditions']=$tcondition;
		$this->paginate['order']='Following_topic_numbers.count desc';
		$this->paginate['limit']=300;
		$this->set('topics',$this->paginate('Topic'));

		$this->getRanking();
	}


	function newtopics(){

		$this->Topic->recursive = 0;
		$tcondition = array(array('Topic.deleted'=>0, 'Topic.hide'=>0));
		$this->paginate['conditions']=$tcondition;
		$this->paginate['order']='created desc';
		$this->paginate['limit']=300;
		$this->set('topics',$this->paginate('Topic'));
		
		$this->getRanking();
	}


	function mytopics(){

                //put the posts the user following in array
                //$following_topic_list = array();
                $following_topic_data = $this->requestAction('followings/following_topic');
		////  condition array  * array[$j]['or'][$i]
		////                     array[$j]['and'][$num]
                $i=0; //numbers of 'or'
		$j=0; //numbers of 'or' and 'and'


		if($following_topic_data){
			foreach($following_topic_data as $fpdata){
				$condition[$j]['or'][$i] = array('Topic.id'=>$fpdata['FollowingTopics']['following_topic_id'], 'Topic.hide'=>0, 'Topic.deleted'=>0);
				$i++;
			}
		}
		else{ //follow no topics
			$condition = array(array('Topic.id'=>0));
		}

		$this->paginate['conditions']=$condition;
		$this->paginate['order']='created desc';
		$this->paginate['limit']=300;
		$this->set('mytopics',$this->paginate('Topic'));

		 $this->getRanking();
	}

	function getRanking(){
		// Ranking
		// get date (today and a month from today)
		$start_ranking_date = gmdate("Y/m/d",strtotime("-1 month"));
		$end_ranking_date = gmdate("Y/m/d H:i:s",strtotime("+1 day"));

		$rcondition = array(
			'conditions'=>array(
				'Topic.deleted'=>0, 
				'Topic.hide'=>0, 
				'Topic.created >=' => $start_ranking_date, 
				'Topic.created <=' => $end_ranking_date
			),
			'limit'=>'5',
			'order'=>array(
				'Comment_topics.count DESC'
			)
		);
		$this->set('topic_ranking', $this->Topic->find('all', $rcondition));

	}
}
?>
