<?php
class CommentsController extends AppController {

	var $name = 'Comments';
	var $helpers = array('Html', 'Form');
	var $layout = 'home';
	var $uses = array('User', 'Comment');

	function index() {
		$this->set('comments', $this->Post->find('all'));
	}

	function add() {
		$me_array = $this->Session->read('Auth.User');
		$me = $me_array['id'];
		$tutorial_flag = $this->Session->read('phase');

		$comment_id = "";
		$topic_id = "";
		if(!empty($this->params['named'])){
			$comment_id = $this->params['named']['cid'];
			$topicid = $this->params['named']['topicid'];
		}

/*
echo "<PRE>";
var_dump($this->data);
echo "</PRE>";
exit;
*/


		if(!empty($this->data)) {
			$this->data['Comment']['user_id'] = $me;
			//$this->data['Comment']['parent_id'] = $this->data['Comment']['comment_id'];


/*
echo "<PRE>";
var_dump($this->data);
echo "</PRE>";
exit;
*/



			if($this->Comment->save($this->data, true, array('user_id', 'topic_id', 'parent_id', 'body'))) {
				///give 10 contribute points to commenting ///
				$query = "update users set `cpoint`=`cpoint`+10 where `id`=".$me;
				$this->User->query($query);

				if($tutorial_flag==90){
					$this->redirect(array("controller" => "tutorials", "action" => "phase", 90, 1));
				}
				else{
					$this->flash('Your posts have been saved','/posts');
					$this->redirect('/');
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
		else if($tutorial_flag==50){
			$tutoria_comment=array();
			$tutoria_comment['Comment']['user_id']=41;
			$tutoria_comment['Comment']['topic_id']=4;
			$tutoria_comment['Comment']['body']="Hi,".$me_array['username'];

			$this->Comment->save($tutoria_comment);

			return;
		}
		else{
			$this->redirect('/home');
		}
	}

	function delete(){
		$comment_id = $this->params['named']['cid'];

		$data = array();
		$data['Comment']['id'] = $comment_id;
		$data['Comment']['deleted'] = 1;

		$this->Comment->begin();
		$this->Comment->save($data, false);
		$this->Comment->commit();
		$this->redirect('/');
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


}
?>
