<?php
class AdministrationsController extends AppController {

	var $name = 'Administrations';
	var $helpers = array('Html', 'Form', 'NiceNumber');
	var $layout = "administration";
	var $uses = array('Topic', 'User', 'Comment');

	function index(){
		$me_array = $this->Session->read('Auth.User');
		$me = $me_array['id'];

		// get topic 100 list
		$topic_query = "select id, title, modified from topics where checked=0 and deleted=0 and hide=0 limit 0,100";
		$topic_array = $this->Topic->query($topic_query);
		$this->set('topics', $topic_array);

		// get comment 100 list
		$comment_query = "select id, body, modified from comments where checked=0 and deleted=0 and hide=0 limit 0,100";
                $comment_array = $this->Comment->query($comment_query);
		$this->set('comments', $comment_array);
	}

	function topic(){
		// query condition variable
		$user_id="";

		// default query condition
		$conditions = array();


		if(!empty($_REQUEST['user_name'])){
			// get user id from user name
			$user_name=$_REQUEST['user_name'];
			$user_id_array = $this->User->query("SELECT id FROM users WHERE username='$user_name'");
			$user_id = intval($user_id_array[0]['users']['id']);

			$topic_sql = "SELECT id, title, body, modified, deleted, checked FROM topics WHERE user_id=".$user_id." ORDER BY id ASC";
			$topic_array = $this->Topic->query($topic_sql);
		}elseif(!empty($_REQUEST['start_date']) || !empty($_REQUEST['end_date'])){
			if(!empty($_REQUEST['start_date'])){
				$start_date = $_REQUEST['start_date'];
			}else{
				$start_date = "2011-04-01";
			}

			if(!empty($_REQUEST['end_date'])){
				$end_date = $_REQUEST['end_date'];
			}else{
				$end_date = "3000-12-31";
			}

			$topic_sql = "SELECT id, title, body, modified, deleted, checked FROM topics WHERE modified BETWEEN '".$start_date."' AND '".$end_date."' ORDER BY id ASC";
			$topic_array = $this->Topic->query($topic_sql);
		}else{ //when no search keyword
			$topic_sql = "SELECT id, title, body, modified, deleted, checked FROM topics WHERE deleted=0 ORDER BY id ASC";
			$topic_array = $this->Topic->query($topic_sql);
		}


		/// get list of topic
		$this->set('topics', $topic_array);
	}

	function topic_detail(){
		// default query condition
		$conditions = array();

		// get topic detail id
		if(!empty($this->params['named']['topicid'])){
			$detail_id =  $this->params['named']['topicid'];
			$conditions['Topic.id'] = $detail_id;
		}

		/// get list of topic
		$params = array(
			'conditions' => $conditions,
			'order' => array('created ASC')
		);
		$topic_array = $this->Topic->find('all', $params);

		$item_array=array();
		if(!empty($topic_array)){
			$item_array['id']=$topic_array[0]['Topic']['id'];
			$item_array['user_id']=$topic_array[0]['Topic']['user_id'];
			$item_array['title']=$topic_array[0]['Topic']['title'];
			$item_array['body']=$topic_array[0]['Topic']['body'];
			$item_array['category']=$topic_array[0]['Topic']['category'];
			$item_array['hide']=$topic_array[0]['Topic']['hide'];
			$item_array['deleted']=$topic_array[0]['Topic']['deleted'];
		}else{
			$item_array['id']="";
			$item_array['user_id']="";
			$item_array['title']="";
			$item_array['body']="";
			$item_array['category']="";
			$item_array['hide']="";
			$item_array['deleted']="";
		}
		$this->set('item_array', $item_array);
	}

	function comment(){
		// query condition variable
		$user_id="";

		// default query condition
		$conditions = array();


		if(!empty($_REQUEST['user_name'])){
			// get user id from user name
			$user_name=$_REQUEST['user_name'];
			$user_id_array = $this->User->query("SELECT id FROM users WHERE username='$user_name'");
			$user_id = intval($user_id_array[0]['users']['id']);

			$comment_sql = "SELECT id, body, topic_id, modified, deleted, checked FROM comments WHERE user_id=".$user_id." ORDER BY id ASC";
			$comment_array = $this->Comment->query($comment_sql);
		}elseif(!empty($_REQUEST['start_date']) || !empty($_REQUEST['end_date'])){
			if(!empty($_REQUEST['start_date'])){
				$start_date = $_REQUEST['start_date'];
			}else{
				$start_date = "2011-04-01";
			}

			if(!empty($_REQUEST['end_date'])){
				$end_date = $_REQUEST['end_date'];
			}else{
				$end_date = "3000-12-31";
			}

			$comment_sql = "SELECT id, body, topic_id, modified, deleted, checked FROM comments WHERE modified BETWEEN '".$start_date."' AND '".$end_date."' ORDER BY id ASC";
			$comment_array = $this->Comment->query($comment_sql);
		}else{ //when no search keyword
			$comment_sql = "SELECT id, body, topic_id, modified, deleted, checked FROM comments WHERE deleted=0 ORDER BY id ASC";
			$comment_array = $this->Comment->query($comment_sql);
		}

		/// get list of comment 
		$this->set('comments', $comment_array);

		/// get topic name by topic_id
		$topic_name_query = "SELECT title FROM topics";
		$topic_name_array_db = $this->Topic->query($topic_name_query);
		$topic_name_array = array("non-title");
		foreach($topic_name_array_db as $tnamedb){
			array_push($topic_name_array, $tnamedb['topics']['title']);
		}
		$this->set('topic_name', $topic_name_array);
	}

	function comment_detail(){
		// default query condition
		$conditions = array();

		// get topic detail id
		if(!empty($this->params['named']['commentid'])){
			$detail_id =  $this->params['named']['commentid'];
			$conditions['Comment.id'] = $detail_id;
		}

		/// get list of topic
		$params = array(
			'conditions' => $conditions,
			//'order' => 'created ASC'
		);

		$comment_array = $this->Comment->find('all', $params);


		$item_array=array();
		if(!empty($comment_array)){
			$item_array['id']=$comment_array[0]['Comment']['id'];
			$item_array['user_id']=$comment_array[0]['Comment']['user_id'];
			$item_array['body']=$comment_array[0]['Comment']['body'];
			$item_array['topic_id']=$comment_array[0]['Comment']['topic_id'];
			$item_array['hide']=$comment_array[0]['Comment']['hide'];
			$item_array['deleted']=$comment_array[0]['Comment']['deleted'];
		

			/// get topic name by topic_id
/*
			$topic_name_query = "SELECT title FROM topics";
			$topic_name_array_db = $this->Topic->query($topic_name_query);
			$topic_name_array = array("non-title");
			foreach($topic_name_array_db as $tnamedb){
				array_push($topic_name_array, $tnamedb['topics']['title']);
			}
			$this->set('topic_name', $topic_name_array);
*/

			$this->set('topic_name', $comment_array[0]['Topic']['title']);

		}else{
			$item_array['id']="";
			$item_array['user_id']="";
			$item_array['body']="";
			$item_array['topic_id']="";
			$item_array['hide']="";
			$item_array['deleted']="";
		}
		$this->set('item_array', $item_array);
	}

	function content_check(){
		//get value from checked item
		$contentid = $_REQUEST['content_check'];
		//value is like this type/id ex. comment/3, topic/2
		//split value [0]=>type  [1]=>id number
		$content_array = split("/",$contentid);

		if($content_array[0]=="comment"){
			$check_query = "update comments set checked=1 where id='".$content_array[1]."'";
			$this->Comment->query($check_query);
		}
		elseif($content_array[0]=="topic"){
			$check_query = "update topics set checked=1 where id='".$content_array[1]."'";
			$this->Topic->query($check_query);
		}

		$this->redirect('/administrations/');
	}

	function checked(){
		/// set 0 to previous checked id, and set 1 to new checked id
		$commentid = $_REQUEST['checked'];
		$lastcheckid = $_REQUEST['last_check_id'];

		$check_delete_query = "update comments set checked=0 where id='".$lastcheckid."'";
		$check_query = "update comments set checked=1 where id='".$commentid."'";

		$this->Comment->query($check_delete_query);
		$this->Comment->query($check_query);

		$this->redirect('/administrations/');
	}

	function modify(){
		// get type(topic or comment)
		$type = $_REQUEST['type'];

		// get variables
		$item_array=array();
		if(!empty($_REQUEST['id'])){
			$item_array['id']=$_REQUEST['id'];
		}else{
			$item_array['id']="";
		}
		if(!empty($_REQUEST['user_id'])){
			$item_array['user_id']=$_REQUEST['user_id'];
		}else{
			$item_array['user_id']="";
		}
		if(!empty($_REQUEST['title'])){
			$item_array['title']=$_REQUEST['title'];
		}else{
			 $item_array['title']="";
		}
		if(!empty($_REQUEST['body'])){
			$item_array['body']=$_REQUEST['body'];
		}else{
			$item_array['body']="";
		}
		if(!empty($_REQUEST['topic_id'])){
			$item_array['topic_id']=$_REQUEST['topic_id'];
		}else{
			 $item_array['topic_id']="";
		}
		if(!empty($_REQUEST['category'])){
			$item_array['category']=$_REQUEST['category'];
		}else{
			$item_array['category']="";
		}
		if(!empty($_REQUEST['hide'])){
			$item_array['hide']=$_REQUEST['hide'];
		}else{
			$item_array['hide']="";
		}
		if(!empty($_REQUEST['deleted'])){
			$item_array['deleted']=$_REQUEST['deleted'];
		}else{
			$item_array['deleted']="";
		}
		
		if($type=="topic"){
			// model topic array
			$topic_array = array();
			$topic_array['Topic']['id'] = $item_array['id'];
			$topic_array['Topic']['user_id'] = $item_array['user_id'];
			$topic_array['Topic']['title'] = $item_array['title'];
			$topic_array['Topic']['body'] = $item_array['body'];
			$topic_array['Topic']['category'] = $item_array['category'];
			$topic_array['Topic']['hide'] = $item_array['hide'];
			$topic_array['Topic']['deleted'] = $item_array['deleted'];

			$this->Topic->save($topic_array);

			$this->redirect('/administrations/');
		}
		elseif($type=="comment"){
			// model comment array
			$comment_array = array();
			$comment_array['Comment']['id'] = $item_array['id'];
			$comment_array['Comment']['user_id'] = $item_array['user_id'];
			$comment_array['Comment']['body'] = $item_array['body'];
			//$comment_array['Comment']['topic_id'] = $item_array['topic_id'];
			$comment_array['Comment']['hide'] = $item_array['hide'];
			$comment_array['Comment']['deleted'] = $item_array['deleted'];

			$this->Comment->save($comment_array);

			$this->redirect('/administrations/');
		}
		else{}
//exit;
	}
}
?>
