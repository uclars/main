<?php
/**
  * check the user is logged in
  * run this function every page
  */
class BlacklistsComponent extends Object {
	var $components = array('Session');
	var $check = null;

	function checkBlacklist(){
		$blacklist_model =& new Blacklist(); //call comment model in order to use find()

		$me_array = $this->Session->read('Auth.User');

		if(!empty($me_array)){ //not in the first page
			$me = $me_array['id'];

			//check it from DB
			$conditions = array('conditions'=>array('user_id'=>$me));
			$userlists = $blacklist_model->find('all', $conditions);

			if(!empty($userlists)){ //if there is a record for that use id
				//$this->redirect("");
				$this->cakeError('error404');
				exit();
			}
		}
	}
}
?>
