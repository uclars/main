<?php
class FollowingsController extends AppController
{
	var $name = 'Followings';
	var $components = array('Auth', 'Session');

	function index(){

	}

	function following_user(){
		$userid= 1;
		$auth = $this->Session->read('Auth.User');

		$conditions = array('user_id' => $auth['id'], 'NOT'=>array('following_user_id'=>'NULL'));
		$order = array('id DESC');
		$following_user = $this->Following->find('all', array('conditions' => $conditions, 'order' => $order));

/*
echo("<PRE>");
var_dump($following_user);
echo("</PRE>");
exit;
*/

		return $following_user;
	}

	function following_post(){
                $userid= 1;
                $auth = $this->Session->read('Auth.User');

                $conditions = array('user_id' => $auth['id'], 'NOT'=>array('following_post_id'=>NULL));
                $order = array('id DESC');
                $following_post = $this->Following->find('all', array('conditions' => $conditions, 'order' => $order));

/*
echo("<PRE>");
var_dump($following_post);
echo("</PRE>");
exit;
*/

                return $following_post;
        }

	function action(){
		$id = $this->params['named']['id'];
		$do = $this->params['named']['do'];

		switch($do){
			case "follow_user":
				$me = $this->Session->read('Auth.User');
				$this->_follow_user($me['id'], $id);
				$msg = "You have followed a user!";
			break;

			case "unfollow_user":
                                $me = $this->Session->read('Auth.User');
				$this->_unfollow_user($me['id'], $id);
				$msg = "You have unfollowed a user!";
			break;

                        case "follow_post":
                                $me = $this->Session->read('Auth.User');
                                $this->_follow_post($me['id'], $id);
                                $msg = "You have followed a post!";
                        break;

                        case "unfollow_post":
                                $me = $this->Session->read('Auth.User');
                                $this->_unfollow_post($me['id'], $id);
                                $msg = "You have unfollowed a post!";
                        break;
		}
		$this->Session->write('msg', $msg);

		$this->redirect('/');
	}

	function _check_count($myself, $myfollowers){
//		$conditions = array(');
//		$c_count = 
return 0;
	}

	function _follow_user($me, $my_followers){
		$count = $this->_check_count($me, $my_followers);		

		if($count == 0){
			$fdata = array();
			$fdata['Following']['user_id'] = $me;
			$fdata['Following']['following_user_id'] = $my_followers;
/*
echo("<PRE>");
var_dump($fdata);
echo("</PRE>");
exit;
*/

			$this->Following->save($fdata);
		}
	}

	function _unfollow_user($me, $my_followers){
                $count = $this->_check_count($me, $my_followers);

                if($count == 0){
			$fdata = array('user_id' => $me, 'following_user_id' => $my_followers);

/*
echo("<PRE>");
var_dump($fdata);
echo("</PRE>");
exit;
*/

                        $this->Following->deleteAll($fdata);
                }
	}

        function _follow_post($me, $my_followers){
                $count = $this->_check_count($me, $my_followers);

                if($count == 0){
                        $fdata = array();
                        $fdata['Following']['user_id'] = $me;
                        $fdata['Following']['following_post_id'] = $my_followers;
/*
echo("<PRE>");
var_dump($fdata);
echo("</PRE>");
exit;
*/

                        $this->Following->save($fdata);
                }
        }

        function _unfollow_post($me, $my_followers){
                $count = $this->_check_count($me, $my_followers);

                if($count == 0){
                        $fdata = array('user_id' => $me, 'following_post_id' => $my_followers);

/*
echo("<PRE>");
var_dump($fdata);
echo("</PRE>");
exit;
*/

                        $this->Following->deleteAll($fdata);
                }
        }

}
?>
