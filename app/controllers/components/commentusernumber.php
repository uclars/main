<?php
/**
  * check the user is logged in
  * run this function every page
  */
class CommentusernumberComponent extends Object {
	var $components = array('Session');
	var $check = null;

/*
	function initialize($controller){
		$user_array = $this->Session->read('Auth.User');

		$this->controller =& $controller;
		if(is_null($user_array)){
			$this->controller->redirect(array("controller"=>"home", "action"=>"index"));
		}
	}
*/


	function getCommentUserNumber($topicid, $me){
		$comment_model =& new Comment(); //call comment model in order to use find()

		$params = array(
                        'conditions' => array('Comment.deleted'=>0, 'Comment.topic_id' => $topicid),
                        'order' => array('User.tpoint desc', 'Comment.created asc')
                );
		$comment_number = $comment_model->find('count', $params);

		return $comment_number;
	}
}
?>
