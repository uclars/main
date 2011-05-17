<?php
class FollowingsController extends AppController
{
	var $name = 'Followings';

	function index(){

	}

	function following_user(){
		$userid= $this->params['userid'];
		$conditions = array('user_id' => $userid, 'NOT'=>array('following_user_id'=>'NULL'));
		$order = array('id DESC');
		$following_user = $this->Following->find('all', array('conditions' => $conditions, 'order' => $order));


/*
echo $userid;
echo("<PRE>");
var_dump($this->params);
echo("</PRE>");
exit;
*/



		return $following_user;
	}

	function following_topic(){
		$me_array = $this->Session->read('Auth.User');
		$me = $me_array['id'];
		$following_topic = null;

		if($me){
			$conditions = array('user_id' => $me, 'NOT'=>array('following_topic_id'=>NULL));
			$order = array('id DESC');
			$following_topic = $this->Following->find('all', array('conditions' => $conditions, 'order' => $order));
		}


/*
echo("<PRE>");
var_dump($me);
echo("</PRE>");
exit;
*/


                return $following_topic;
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

                        case "follow_topic":
                                $me = $this->Session->read('Auth.User');
                                $this->_follow_topic($me['id'], $id);
                                $msg = "You have followed a topic!";
                        break;

                        case "unfollow_topic":
                                $me = $this->Session->read('Auth.User');
                                $this->_unfollow_topic($me['id'], $id);
                                $msg = "You have unfollowed a topic!";
                        break;
		}
		$this->Session->write('msg', $msg);

		$tutorial_flag = $this->Session->read('phase');

		/// if in tutorial, redirect to the tutorial page
		/// else, redirect to the top paeg
		if(!empty($tutorial_flag)){
			$this->redirect('/tutorials/phase/3');
		}
		else{
			$this->redirect('/');
		}
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

        function _follow_topic($me, $my_followers){
                $count = $this->_check_count($me, $my_followers);

                if($count == 0){
                        $fdata = array();
                        $fdata['Following']['user_id'] = $me;
                        $fdata['Following']['following_topic_id'] = $my_followers;
/*
echo("<PRE>");
var_dump($fdata);
echo("</PRE>");
exit;
*/

                        $this->Following->save($fdata);
                }
        }

        function _unfollow_topic($me, $my_followers){
                $count = $this->_check_count($me, $my_followers);

                if($count == 0){
                        $fdata = array('user_id' => $me, 'following_topic_id' => $my_followers);

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
