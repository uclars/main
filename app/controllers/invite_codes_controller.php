<?php
class InviteCodesController extends AppController {

	var $components = array('Auth', 'Facebook.Connect','Session');
	var $name = 'InviteCodes';
	var $helpers = array('Html', 'Form');
	var $layout = "home";
	var $uses = array('InviteCode','User');

	//### アクションが実行される前に実行 ###
	function beforeFilter() {
		//親クラス呼出
		parent::beforeFilter();
		//[Auth]例外設定
		$this->Auth->allow('*');
	}

	function index(){
		$inputcode=$this->data['InviteCodes']['Invite']['code'];

		//check input code is on the database
		//if the code is on the database, show the register view, if not redirect top.
		if(!empty($inputcode)){
			$code_check = $this->InviteCode->find('first',array(
				'field'=>'id',
				'conditions'=>array('code'=>$inputcode))
			);

			///User used up the total number of invite code or $code_check is false(invalid code)
			if($code_check['InviteCode']['remain_num'] < 1){
				$this->redirect('/');
			}
			else{
				/// Check if the user is already on the database
				$this->Session->write('invite', true);
				$this->Session->write('phase', 0);
				//$this->redirect(array('controller'=>'tutorials', 'action'=>'phase', 0));

				///insert number
				$query = "update invite_codes set `total_num`=`total_num`+1 where `code`=\"".$inputcode."\"";

echo $query;


				$this->InviteCode->query($query);

				$this->redirect('/');
			}
		}
		else{
			$this->redirect(array('controller'=>'users', 'action'=>'logout'));
		}
	}

	function two(){
		var_dump($this->Session->read('Auth.User'));
	}
}
?>
