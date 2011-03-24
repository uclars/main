<?php
//### CREATE 2010/06/20 Pyon ###
class AppController extends Controller {

	var $uses = array('Request');
	//[Auth]ユーザ認証(必須に)
	var $components = array('Auth');

	//### アクションが実行される前に実行 ###
	function beforeFilter() {
		//[Auth]エラーメッセージ変更
		$this->Auth->loginError = 'IDまたはパスワードが違います。';
		$this->Auth->authError = 'ログインしてください。';
		//[Auth]login処理を有効に(Redirectは自前で)
		$this->Auth->autoRedirect = false;
		//表示値セット
		if ($this->Auth->user()) {
			$this->set('auth', $this->Auth->user());
		}
	}

	//### リクエストID取得 ###
	function _getRequestId() {
		//一定期間経過してるレコードを削除
		$this->Request->deleteAll(array('Request.created <=' => date('Y-m-d H:i:s', strtotime('-1 hours'))), false);
		//ユニークな値をセット
		$data = array();
		$i = 0;
		while ($i < 10) {
			$data['Request']['id'] = md5(uniqid(rand(),1));
			if ($this->Request->save($data, false)) { break; } 
			$i++;
		}
		return ($i < 10) ? $data['Request']['id'] : '';
	}

}
?>