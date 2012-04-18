<?php
class CommentsController extends AppController {

	var $name = 'Comments';
	var $helpers = array('Html', 'Form', 'Session');
	var $layout = 'home';
	var $uses = array('User', 'Comment', 'CommentGood');
	var $components = array('Auth', 'Facebook.Connect', 'Session');

	function index() {
		$this->set('comments', $this->Post->find('all'));
	}

	function add() {
		$me_array = $this->Session->read('Auth.User');
		$me = $me_array['id'];

		///for anonymous users
		if(is_null($me)){
			$me=1;
		}

		$tutorial_flag = $this->Session->read('phase');

		$comment_id = "";
		$topic_id = "";


// NEED TO recode here!!!
		if(!empty($this->params['named'])){
//			$comment_id = $this->params['named']['cid'];
//			$topicid = $this->params['named']['topicid'];
		}

		if(!empty($this->data)) {
			$this->data['Comment']['user_id'] = $me;



/*
echo "<PRE>";
var_dump($this->params['named']['comments']);
echo "</PRE>";
exit;
*/



			if($this->Comment->save($this->data, true, array('user_id', 'topic_id', 'parent_id', 'body'))) {
				///give 10 contribute points to commenting ///
				$query = "update users set `cpoint`=`cpoint`+10 where `id`=".$me;
				$this->User->query($query);

				if($tutorial_flag==60){
					$tutoria_comment=array();
					$tutoria_comment['Comment']['user_id']=74;
					$tutoria_comment['Comment']['topic_id']=4;
					$tutoria_comment['Comment']['body']="Hi, ".$me_array['username'];

					$this->Comment->save($tutoria_comment);

					return;
				}
				else if($tutorial_flag==90){
					$tutoria_comment=array();
					$tutoria_comment['Comment']['user_id']=$me;
					$tutoria_comment['Comment']['topic_id']=1;
					$tutoria_comment['Comment']['body']=$this->data['User']['body'];

					$this->Comment->save($tutoria_comment);

					return;
//					$this->redirect(array("controller" => "tutorials", "action" => "phase", 90, 1));
				}
				else{


/*
コメントした後、自分のコメントのページにリダイレクトされるようにしたい

					$commid = $this->_getCommentId($me); //get commnet id for redirecting the page in which shows the comment
					$comment_num = $this->Comment->find('count', array(
						'conditions' => array('Comment.deleted' => 0, 'Comment.topic_id' => $this->data['Comment']['topic_id'], 'Comment.id <'=>$commid),
						'order' => array('User.tpoint desc', 'Comment.created desc')
					));
echo "<PRE>";
var_dump($comment_num);
echo "</PRE>";
exit;
*/



					$this->redirect(array("controller" => "topics", "action" => "show_topic", "page"=>1, "topicid"=>$this->data['Comment']['topic_id']));
				}
			}
		}
		else if(!empty($comment_id)){
			$params = array(
				'conditions' => array('Comment.id'=>$comment_id),
			);

			$target_comment = $this->Comment->find('all', $params);
			$this->set('target_comment', $target_comment[0]['Comment']['body']);
			$this->set('topic_id', $topicid);
			$this->set('comment_id', $comment_id);



/*
echo "<PRE>";
var_dump($target_comment[0]['Comment']['body']);
echo "</PRE>";
exit;
*/



			return;

		}
/*		else if($tutorial_flag==60){
			$tutoria_comment=array();
			$tutoria_comment['Comment']['user_id']=74;
			$tutoria_comment['Comment']['topic_id']=4;
			$tutoria_comment['Comment']['body']="Hi,".$me_array['username'];

			$this->Comment->save($tutoria_comment);

			return;
		}*/
		else{
			$this->redirect('/home');
		}
	}

	function delete(){
		$referer = $_SERVER['HTTP_REFERER'];
		$comment_id = $this->params['named']['cid'];

		$data = array();
		$data['Comment']['id'] = $comment_id;
		$data['Comment']['deleted'] = 1;

		$this->Comment->begin();
		$this->Comment->save($data, false);
		$this->Comment->commit();
		$this->redirect($referer);
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

	function administration(){


$hide = $_REQUEST["hide"];
$delete = $_REQUEST["delete"];

echo "<PRE>";
var_dump($hide);
var_dump($delete);
echo "</PRE>";
exit;

	}


	function _getCommentId($meid){
		$comment_now=$this->Comment->find('first', array('conditions'=>array(
						'Comment.user_id'=>$meid,
						'Comment.topic_id'=>$this->data['Comment']['topic_id'],
						'Comment.body'=>$this->data['Comment']['body']
					),
					'order'=>array(
						array('created DESC')
					)
				));
		return $comment_now['Comment']['id'];
	}

	function good(){
		$me_array = $this->Session->read('Auth.User');
		$me = $me_array['id'];

		$topic_id = $this->params['named']['topicid'];
		$comment_id =  $this->params['named']['cid'];
		$data = array();
		$referer = $this->referer();

		///increment 1 to the good attribute ///
//		$query = "update comments set `good`=`good`+1 where `id`=".$comment_id;
//		$this->Comment->begin();
//		$this->Comment->query($query);
//		$this->Comment->commit();

		////  save to the database  ////
		$data['CommentGood']['user_id'] = $me;
		$data['CommentGood']['topic_id'] = $topic_id;
		$data['CommentGood']['comment_id'] = $comment_id;
		$data['CommentGood']['good'] = 1;

		$this->CommentGood->begin();
		$this->CommentGood->save($data, false);
		$this->CommentGood->commit();
		$this->redirect($referer);
	}

	function bad(){
		$me_array = $this->Session->read('Auth.User');
		$me = $me_array['id'];

		$topic_id = $this->params['named']['topicid'];
		$comment_id =  $this->params['named']['cid'];
		$referer = $this->referer();

		///increment 1 to the bad attribute ///
		//$query = "update comments set `bad`=`bad`+1 where `id`=".$comment_id;
		//$this->Comment->begin();
		//$this->Comment->query($query);
		//$this->Comment->commit();

		////  save to the database  ////
		$data['CommentGood']['user_id'] = $me;
		$data['CommentGood']['topic_id'] = $topic_id;
		$data['CommentGood']['comment_id'] = $comment_id;
		$data['CommentGood']['bad'] = 1;

		$this->CommentGood->begin();
		$this->CommentGood->save($data, false);
		$this->CommentGood->commit();		
		$this->redirect($referer);
	}
}
?>
