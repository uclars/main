<?php
class PostsController extends AppController
{
	var $name='Posts';
	var $components = array('Session');
	var $helpers = array('Session');
	var $layout = "home";

	function index() {
//		$this->set('posts', $this->Post->find('all'));


$this->Session->start(); 

echo "HHH#";
echo "<PRE>";
var_dump($this->Session->read('Auth.User'));
var_dump($this->Session);
var_dump($_SESSION);
echo "</PRE>";

exit;

	}

	function view($id = null) {
		$this->Post->id = $id;
		$this->set('post', $this->Post->read());
	}
}
?>
