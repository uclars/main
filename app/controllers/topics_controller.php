<?php
class TopicsController extends AppController {

	var $components = array('Auth', 'Facebook.Connect', 'Session', 'Commentusernumber');
	var $name = 'Topics';
	var $helpers = array('Html', 'Form', 'NiceNumber', 'Session');
	var $layout = "topic";
	var $uses = array('Topic', 'User', 'Comment','CommentGood', 'MasterCategory','RelatedTopic');
	//var $components = array('Logincheck');

	function beforeFilter() {
		//show the page without login
		$this->Auth->allow('*');

		//get current url
		$url = $this->here;
		$title_array = split(":",$url);
		if(!empty($title_array[1])){
			$title_id = $title_array[1];
			$title_sql = $this->Topic->find('all',array(
				'conditions'=>array('Topic.id'=>$title_id),
				'fields' => array('`Topic`.`title`')
				)
			);
			$this->Session->write('title',$title_sql[0]['Topic']['title']);
		}
	}

	function index(){
		//get all topics
		$params = array(
			'conditions' => array('Topic.deleted'=>0, 'Topic.hide'=>0),
			'order' => array('created DESC')
		);

		$this->set('topics', $this->Topic->find('all', $params));

		$me_array = $this->Session->read('Auth.User');
		$me = $me_array['id'];

		//get following info
		$following_topic_list = array();

		//get the topics list
		$following_topic_list = $this->_getFollowingTopicList($me);
		$this->set('following_topic_list', $following_topic_list);
	}

	function show_topic() {
		$topic_id = $this->params['named']['topicid'];
		$topic_array = $this->Topic->find('all', array('conditions' => array('Topic.id' => $topic_id)));
		$this->set('topics', $topic_array);
		$this->set('topictitle', $topic_array[0]['Topic']['title']);

		//get picture of topic owner
		$topic_array_pic = $this->User->find('all', array('conditions' => array('User.id' => $topic_array[0]['Topic']['user_id']),'recursive' => -2));
		$this->set('topic_user_pic', $topic_array_pic);


		$me_array = $this->Session->read('Auth.User');
		$me = $me_array['id'];

		//pagenate
		$this->paginate = array(
			'conditions' => array('Comment.deleted' => 0, 'Comment.hide' => 0, 'Comment.topic_id' => $topic_id),
			'limit' => 200,
			'order' => array('User.tpoint desc', 'Comment.created asc')
		);
		$this->set('comments',$this->paginate('Comment'));	


		/// get the number of users who commented on the topic
//		$comment_user_number = $this->Commentusernumber->getCommentUserNumber($topic_id, $me);
//		$this->set('comment_user_number',$comment_user_number);




/*
		$params = array(
			'conditions' => array('Comment.deleted' => 0, 'Comment.topic_id' => $topic_id),
			'order' => array('created DESC')
		);
		$com = $this->Comment->find('all', $params);

		//$com = $this->Comment->find('all', array('conditions'=>array('topic_id'=>$topic_id, 'Comment.deleted' => 0)));
		$this->set('comments', $com);
*/


		//get the topics list
		$following_topic_list = array();
		$following_topic_list = $this->_getFollowingTopicList($me);
		$this->set('following_topic_list', $following_topic_list);		

		//get the goods or bads for the comments
		$commentgood = array();
		$commentgood = $this->_getCommentGood('good', $me, $topic_id);
		$this->set('comment_good', $commentgood);
		$commentbad = array();
		$commentbad = $this->_getCommentGood('bad', $me, $topic_id);
		$this->set('comment_bad', $commentbad);

		//get Popular topics
		$this->_getPopularTopics($topic_id);
	}

	function topiccatlist(){
		$me_array = $this->Session->read('Auth.User');
		$me = $me_array['id'];
//		$this->set('me', $me);

		//get topic list for the specific category
		$topic__category_id = $this->params['named']['catid'];
		$params = array(
			'conditions' => array('Topic.deleted'=>0, 'Topic.hide'=>0, 'Topic.category'=>$topic__category_id),
			'order' => array('created DESC')
		);
		$this->set('topic_cat', $this->Topic->find('all', $params));


		//get following info
		$following_topic_list = array();

		//get the topics list
		$following_topic_list = $this->_getFollowingTopicList($me);
		$this->set('following_topic_list', $following_topic_list);
	}

	function view($id) {
		//$this->Topic->id=$id;
		//$this->set('topic', $this->Topic->read());
	}

	function create() {
		$me_array = $this->Session->read('Auth.User');
		$me = $me_array['id'];

		if(!empty($this->data)){
			//if(!$this->User->validates($this->data))　<=　こうしてみたけどダメだった・・・
			if($this->Topic->create($this->data) && $this->Topic->validates()){
				$data = array();
				$data['title'] = $this->data['Topic']['title'];
				$data['body'] = $this->data['Topic']['body'];
				$data['user_id'] = $me;
				if($this->Topic->save($data)){
					///get related topic date which is croned usually.
					$this->getRelatedTopoic();

					$this->redirect('/');
				}else{
					
				}
			}else{


var_dump($this->Topic->invalidFields());



				//SELECT Option
				$option=Set::Combine($this->MasterCategory->find('all'), '{n}.MasterCategory.id', '{n}.MasterCategory.name');
				$this->set('options', $option);
				
			}
		}
		else{ //data is empty
			//SELECT Option
			$option=Set::Combine($this->MasterCategory->find('all'), '{n}.MasterCategory.id', '{n}.MasterCategory.name');
			$this->set('options', $option);
		}
		$this->render('create','topiccreate'); //change layout for create
	}		

	function getCategory(){
		//SELECT Option
		$option=Set::Combine($this->MasterCategory->find('all'), '{n}.MasterCategory.id', '{n}.MasterCategory.name');
		return $option;
	}

	function action(){
                $id = $this->params['named']['id'];
                $do = $this->params['named']['do'];

                switch($do){
                        case "follow":
                                $me = $this->Session->read('Auth.User');
                                $this->_follow_user($me['id'], $id);
                                $msg = "You have followed a user!";
                        break;

                        case "unfollow":
                                $me = $this->Session->read('Auth.User');
                                $this->_unfollow_user($me['id'], $id);
                                $msg = "You have unfollowed a user!";
                        break;
                }
                $this->Session->write('msg', $msg);

                $this->redirect('/');
        }


	function _getFollowingTopicList($userid){
		$following_topic_list = array();
		$topic_list = $this->requestAction(array(
				'controller' => 'followings',
				'action' => 'following_topic'
			));

		$i=0;
		if(!is_null($topic_list)){
			foreach($topic_list as $tlist){
				$following_topic_list[$i]=$tlist['FollowingTopics']['following_topic_id'];
				$i++;
			}
		}

		return $following_topic_list;
	}
	
	function _getCommentGood($type, $me, $topic_id){
		$comment_good = array();

		//get all comment ids in this topic
		$tcondition = array(
			'conditions'=>array(
				'Comment.topic_id'=>$topic_id
			),
			'fields' => array('`Comment`.`id`'), //get only comment id
		);
		$comment_ids_array = $this->Comment->find('all',$tcondition);

		/// foreach comment ids to get good/bad number
		$i=0;
		foreach($comment_ids_array as $comidarray){
			if($type=='good'){
				$gcondition = array(
					'conditions'=>array(
						'CommentGood.comment_id'=>$comidarray['Comment']['id'],
						'CommentGood.topic_id'=>$topic_id,
						'CommentGood.good'=>1
					),
				);
			}
			elseif($type=='bad'){
				$gcondition = array(
					'conditions'=>array(
						'CommentGood.comment_id'=>$comidarray['Comment']['id'],
						'CommentGood.topic_id'=>$topic_id,
						'CommentGood.bad'=>1
					),
				);

			}
			else{}

			///get good / bad number in each comment id, and put them in the array
			$comment_good[$comidarray['Comment']['id']] = $this->CommentGood->find('count', $gcondition);

			$i++;
		}

		return $comment_good;
	}


	function _getPopularTopics($topic_id){
		$first=$second=$third=$forth=$fifth=$sixth=$seventh=$eighth=$ninth=$tenth=array('id','title');
                $ranking_topic_array = array();
                $ranking_topic = array();
                $ranking_topic_array = $this->RelatedTopic->find('all',array(
                                'conditions'=>array('topic_id'=>$topic_id),
                                'fields'=>array(
                                        'first','second','third','forth','fifth','sixth','seventh','eighth','ninth','tenth'
                                )
                        )
                );

		///just after creating topic, there is no record on the related_topics table
		if(!empty($ranking_topic_array)){
			$first['id']=$ranking_topic_array[0]['RelatedTopic']['first'];
			$first['title']=$this->_getTopicId($first['id']);
			$second['id']=$ranking_topic_array[0]['RelatedTopic']['second'];
			$second['title']=$this->_getTopicId($second['id']);
			$third['id']=$ranking_topic_array[0]['RelatedTopic']['third'];
			$third['title']=$this->_getTopicId($third['id']);
			$forth['id']=$ranking_topic_array[0]['RelatedTopic']['forth'];
			$forth['title']=$this->_getTopicId($forth['id']);
			$fifth['id']=$ranking_topic_array[0]['RelatedTopic']['fifth'];
			$fifth['title']=$this->_getTopicId($fifth['id']);
			$sixth['id']=$ranking_topic_array[0]['RelatedTopic']['sixth'];
			$sixth['title']=$this->_getTopicId($sixth['id']);
			$seventh['id']=$ranking_topic_array[0]['RelatedTopic']['seventh'];
			$seventh['title']=$this->_getTopicId($seventh['id']);
			$eighth['id']=$ranking_topic_array[0]['RelatedTopic']['eighth'];
			$eighth['title']=$this->_getTopicId($eighth['id']);
			$ninth['id']=$ranking_topic_array[0]['RelatedTopic']['ninth'];
			$ninth['title']=$this->_getTopicId($ninth['id']);
			$tenth['id']=$ranking_topic_array[0]['RelatedTopic']['tenth'];
			$tenth['title']=$this->_getTopicId($tenth['id']);
		}

                $this->set('first', $first);
                $this->set('second', $second);
                $this->set('third', $third);
                $this->set('forth', $forth);
                $this->set('fifth', $fifth);
                $this->set('sixth', $sixth);
                $this->set('seventh', $seventh);
                $this->set('eighth', $eighth);
                $this->set('ninth', $ninth);
                $this->set('tenth', $tenth);
	}

	function _getTopicId($topicid){
		$title_array=array();
		$title_array=$this->Topic->find('all',array('conditions'=>array('Topic.id'=>$topicid),'fields'=>array('Topic.title')));

		return $title_array[0]['Topic']['title'];
	}

	function getRelatedTopoic(){
		$cmd = '/usr/bin/php /var/www/html/main/cake/console/cake.php relatedtopics -app /var/www/html/main/app';
		exec($cmd, $arr, $res);
		if ($res === 0) {
			return true;
		} else {
			return false;
		}
	}

	function test(){
		var_dump($this->Session);
	}

}
?>
