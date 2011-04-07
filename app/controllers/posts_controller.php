<?php
class PostsController extends AppController {

	var $name = 'Posts';

	function index() {
		$this->set('posts', $this->Post->find('all'));
	}

	function view($id) {
		$this->Post->id=$id;
		$this->set('post', $this->Post->read());
	}

	function add() {
		if(!empty($this->data)) {
			if($this->Post->save($this->data, true, array('body'))) {
				$this->flash('Your posts have been saved','/posts');
				return;
			}
		}
		$this->redirect('/home');
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
