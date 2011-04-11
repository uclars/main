<?php
class TopicsController extends AppController {

	var $name = 'Topics';

	function index() {
		$this->set('topics', $this->Post->find('all'));
	}

	function view($id) {
		$this->Topic->id=$id;
		$this->set('topic', $this->Topic->read());
	}

	function add() {
		if(!empty($this->data)) {
			if($this->Topic->save($this->data, true, array('body'))) {
				$this->flash('Your topic have been saved','/posts');
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
