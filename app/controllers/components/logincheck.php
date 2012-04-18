<?php
/**
  * check the user is logged in
  * run this function every page
  */
class LogincheckComponent extends Object {
  
	var $components = array('Session');
	var $check = null;

	function initialize($controller){
		$user_array = $this->Session->read('Auth.User');

		$this->controller =& $controller;
		if(is_null($user_array)){
			$this->controller->redirect(array("controller"=>"home", "action"=>"index"));
		}
	}

}
?>
