<?php
class FollowingsController extends AppController
{
	var $name = 'Followings';
	var $uses = array('FollowingUsers', 'FollowingTopics');

	function index(){

	}

	function following_user(){
		$me_array = $this->Session->read('Auth.User');

		if(!empty($this->params['userid'])){
			$userid= $this->params['userid'];
		}
		else{
			if(!empty($me_array)){ ///login user
				$userid = $me_array['id'];
			}
			else{ //don't login yet
				return;
			}
		}
		$conditions = array('user_id' => $userid, 'deleted' => 0, 'NOT'=>array('following_user_id'=>'NULL'));
		$order = array('id DESC');
		$following_user = $this->FollowingUsers->find('all', array('conditions' => $conditions, 'order' => $order));

		return $following_user;
	}

	function following_topic(){
		$me_array = $this->Session->read('Auth.User');
		$me = $me_array['id'];
		$following_topic = null;

		if($me){
			$conditions = array('user_id' => $me, 'deleted' => 0, 'NOT'=>array('following_topic_id'=>NULL));
			$order = array('id DESC');
			$following_topic = $this->FollowingTopics->find('all', array('conditions' => $conditions, 'order' => $order));
		}


/*
echo("<PRE>");
var_dump($following_topic);
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
			if($tutorial_flag==20){
				$this->redirect(array("controller" => "tutorials", "action" => "phase", 20, 1));
			}
			elseif($tutorial_flag==50){
				$this->redirect(array("controller" => "tutorials", "action" => "phase", 50, 1));
			}
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
			$fdata['FollowingUsers']['user_id'] = $me;
			$fdata['FollowingUsers']['following_user_id'] = $my_followers;


/*
echo("<PRE>");
var_dump($fdata);
echo("</PRE>");
exit;
*/



			$this->FollowingUsers->save($fdata);


//echo  $this->element('sql_dump');

		}
	}

	function _unfollow_user($me, $my_followers){
                $count = $this->_check_count($me, $my_followers);

                if($count == 0){
			$fcondition=array('user_id' => $me, 'following_user_id' => $my_followers, 'deleted' => 0);
			$fdata = $this->FollowingUsers->find('first', array('conditions'=>$fcondition));
			$fdata['FollowingUsers']['deleted'] = 1;
			


/*
echo("<PRE>");
var_dump($fdata);
echo("</PRE>");
exit;
*/



                        $this->FollowingUsers->save($fdata);
                }
	}

        function _follow_topic($me, $my_followers){
                $count = $this->_check_count($me, $my_followers);

                if($count == 0){
			$fdata = array();
			$fdata['FollowingTopics']['user_id'] = $me;
			$fdata['FollowingTopics']['following_topic_id'] = $my_followers;


/*
echo("<PRE>");
var_dump($fdata);
echo("</PRE>");
exit;
*/

                        $this->FollowingTopics->save($fdata);
                }
        }

        function _unfollow_topic($me, $my_followers){
                $count = $this->_check_count($me, $my_followers);

                if($count == 0){
			$fcondition=array('user_id' => $me, 'following_topic_id' => $my_followers, 'deleted' => 0);
			$fdata = $this->FollowingTopics->find('first', array('conditions'=>$fcondition));
			$fdata['FollowingTopics']['deleted'] = 1;


/*
echo("<PRE>");
var_dump($fdata);
echo("</PRE>");
exit;
*/

                        $this->FollowingTopics->save($fdata);
                }
        }

}
?>
