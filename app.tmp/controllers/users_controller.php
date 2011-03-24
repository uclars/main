<?php
//### CREATE 2010/06/20 Pyon ###
class UsersController extends AppController {

	var $name = 'Users';
	var $helpers = array('Html', 'Form');
	var $uses = array('User', 'Article', 'Comment', 'Request');

	//### アクションが実行される前に実行 ###
	function beforeFilter() {
		//親クラス呼出
		parent::beforeFilter();
		//[Auth]例外設定
		$this->Auth->allow('add', 'delete');
	}

	//### [Auth]ログイン ###
	function login() {
		//初回表示
		if (empty($this->data)) {
			//ログイン中
			if ($this->Auth->user()) {
				//エラー画面出力
				$this->set('msg', '既にログインしています。');
				$this->render('/errors/custom');
			}
		//ログインボタン押下時＆ログイン成功
		} else if ($this->Auth->user()) {
			//論理削除チェック
			if ($this->Auth->user('deleted') != 0) {
				//強制ログアウト
				$this->Session->setFlash('IDまたはパスワードが違います。');
				$this->redirect($this->Auth->logout());
			} else {
				//元の画面に遷移(但し、ログイン・ログアウト・不明はホームへ)
				if ($this->Session->check('Auth.redirect')) {
					$redir = $this->Session->read('Auth.redirect');
					$this->Session->delete('Auth.redirect');
					$this->redirect(((strcmp(substr($redir, -6), '/login') == 0) || (strcmp(substr($redir, -7), '/logout') == 0)) ? '/' : $redir);
				} else {
					$this->redirect('/');
				}
			}
		}
	}

	//### [Auth]ログアウト ###
	function logout() {
		//ログアウト
		$this->Session->setFlash('ログアウトしました。');
		$this->Auth->logout();
		//ホームに遷移
		$this->redirect('/');
	}

	//### ユーザ一覧 ###
	function index() {
		//ユーザデータセット
		$this->User->recursive = 0;
		$this->User->bindModel(array(
			'hasOne' => array(
				'ArticleUser' => array(
					'className' => 'ArticleUser',
					'foreignKey' => 'user_id',
					'fields' => 'ArticleUser.Count',
					'type' => 'LEFT'
				),
				'CommentUser' => array(
					'className' => 'CommentUser',
					'foreignKey' => 'user_id',
					'fields' => 'CommentUser.Count',
					'type' => 'LEFT'
				)
			)
		), false);
		$this->paginate = array('order' => 'User.id DESC');
		$this->set('datas', $this->paginate(array('User.deleted' => 0)));
	}
	
	//### 新規登録 ###
	function add() {
		//ログイン中
		if ($this->Auth->user()) {
			//エラー画面出力
			$this->set('msg', '既に登録済みです。');
			$this->render('/errors/custom');
		//初回表示時
		} else if (empty($this->data)) {
			//重複登録対策(キー発行)
			$this->data['Request']['id'] = AppController::_getRequestId();
			if (strcmp($this->data['Request']['id'], '') == 0) {
				//エラー画面出力
				$this->set('code', '210');
				$this->render('/errors/custom');
			}
		//重複登録対策(キーチェック)
		} else if ($this->Request->find('count', array('conditions' => array('Request.id' => $this->data['Request']['id'], 'Request.deleted' => 0))) == 0) {
			//完了画面出力
			$this->data['User']['password'] = $this->data['User']['password_new'];
			$this->render('add_end');
		//戻るボタン押下時
		} else if (!(empty($this->data['Back']))) {
		//送信ボタン押下時
		} else {
			//入力チェック
			$data = array();
			$data['User']['name'] = $this->data['User']['name'];
			$data['User']['username'] = $this->data['User']['username'];
			$data['User']['password_new'] = $this->data['User']['password_new'];
			$data['User']['password_chk'] = $this->data['User']['password_chk'];
			$this->User->create($data);
			if (!($this->User->validates())) {
				$this->Session->setFlash('入力内容に誤りがあります。訂正してください。');
			} else {
				//表示値セット
				$this->set('data', $this->data);
				//確認画面出力
				if (!(empty($this->data['Check']))) {
					$this->render('add_chk');
				} else {
					//保存データ更新
					unset($data['User']['password_new']);
					unset($data['User']['password_chk']);
					$data['User']['password'] = $this->Auth->password($this->data['User']['password_new']);
					//重複登録対策(キー論理削除)
					$request = array();
					$request['Request']['id'] = $this->data['Request']['id'];
					$request['Request']['deleted'] = 1;
					//DB保存
					$this->User->begin();
					$this->Request->begin();
					if ((!($this->User->save($data, false))) || (!($this->Request->save($request, false)))) {
						$this->User->rollback();
						$this->Request->rollback();
						//エラー画面出力
						$this->set('code', '211');
						$this->render('/errors/custom');
					} else {
						$this->User->commit();
						$this->Request->commit();
						//ログイン後の遷移先クリア
						$this->Session->delete('Auth.redirect');
						//完了画面出力
						$this->data['User']['password'] = $this->data['User']['password_new'];
						$this->render('add_end');
					}
				}
			}
		}
	}

	//### 登録内容変更 ###
	function edit() {
		//初回表示時
		if (empty($this->data)) {
			//初期値セット
			$this->data = $this->Auth->user();
			//重複登録対策(キー発行)
			$this->data['Request']['id'] = AppController::_getRequestId();
			if (strcmp($this->data['Request']['id'], '') == 0) {
				//エラー画面出力
				$this->set('code', '220');
				$this->render('/errors/custom');
			}
		//重複登録対策(キーチェック)
		} else if ($this->Request->find('count', array('conditions' => array('Request.id' => $this->data['Request']['id'], 'Request.deleted' => 0))) == 0) {
			//完了画面出力
			$this->render('edit_end');
		//戻るボタン押下時
		} else if (!(empty($this->data['Back']))) {
		//送信ボタン押下時
		} else {
			//入力チェック
			$data = array();
			$data['User']['id'] = $this->Auth->user('id');
			$data['User']['name'] = $this->data['User']['name'];
			$data['User']['username'] = $this->data['User']['username'];
			$data['User']['password_new'] = $this->data['User']['password_new'];
			$data['User']['password_chk'] = $this->data['User']['password_chk'];
			$this->User->create($data);
			if (!($this->User->validates())) {
				$this->Session->setFlash('入力内容に誤りがあります。訂正してください。');
			} else {
				//表示値セット
				$this->set('data', $this->data);
				//確認画面出力
				if (!(empty($this->data['Check']))) {
					$this->render('edit_chk');
				} else {
					//保存データ更新
					unset($data['User']['password_new']);
					unset($data['User']['password_chk']);
					if (strcmp($this->data['User']['password_new'], "") != 0) {
						$data['User']['password'] = $this->Auth->password($this->data['User']['password_new']);
					}
					//重複登録対策(キー論理削除)
					$request = array();
					$request['Request']['id'] = $this->data['Request']['id'];
					$request['Request']['deleted'] = 1;
					//DB保存
					$this->User->begin();
					$this->Request->begin();
					if ((!($this->User->save($data, false))) || (!($this->Request->save($request, false)))) {
						$this->User->rollback();
						$this->Request->rollback();
						//エラー画面出力
						$this->set('code', '221');
						$this->render('/errors/custom');
					} else {
						$this->User->commit();
						$this->Request->commit();
						//ユーザ情報更新
						$auth = $this->Auth->user();
						$auth['User']['name'] = $data['User']['name'];
						$auth['User']['username'] = $data['User']['username'];
						$this->Session->write('Auth', $auth);
						//表示値再セット
						$this->set('auth', $this->Auth->user());
						//完了画面を省略してホームに遷移
						if (!(empty($this->data['Next']))) {
							$this->Session->setFlash('変更が完了しました。');
							$this->redirect('/');
						} else {
							//完了画面出力
							$this->render('edit_end');
						}
					}
				}
			}
		}
	}

	//### 退会 ###
	function delete() {
		//重複登録対策(キーチェック)
		if ((!(empty($this->data))) && ($this->Request->find('count', array('conditions' => array('Request.id' => $this->data['Request']['id'], 'Request.deleted' => 0))) == 0)) {
			//完了画面出力
			$this->render('delete_end');
		//ログインチェック
		} else if (!($this->Auth->user())) {
			//ログイン画面に遷移
			$this->Session->write('Auth.redirect', '/users/delete');
			$this->redirect(array('action' => 'login'));			
		//初回表示時
		} else if (empty($this->data)) {
			//初期値セット
			$this->data = $this->Auth->user();
			//重複登録対策(キー発行)
			$this->data['Request']['id'] = AppController::_getRequestId();
			if (strcmp($this->data['Request']['id'], '') == 0) {
				//エラー画面出力
				$this->set('code', '230');
				$this->render('/errors/custom');
			}
		//送信ボタン押下時
		} else {
			//保存データ作成
			$data = array();
			$data['User']['id'] = $this->Auth->user('id');
			$data['User']['deleted'] = 1;
			//重複登録対策(キー論理削除)
			$request = array();
			$request['Request']['id'] = $this->data['Request']['id'];
			$request['Request']['deleted'] = 1;
			//DB保存
			$this->User->begin();
			$this->Request->begin();
			$this->Article->begin();
			if ((!($this->User->save($data, false))) || (!($this->Request->save($request, false)))) {
				$this->User->rollback();
				$this->Request->rollback();
				//エラー画面出力
				$this->set('code', '231');
				$this->render('/errors/custom');
			//退会者の投稿を論理削除
			} else if (!($this->Article->updateAll(array('Article.modified' => date("'Y-m-d H:i:s'"), 'Article.deleted' => 1), array('Article.user_id' => $this->Auth->user('id'))))) {
				$this->User->rollback();
				$this->Request->rollback();
				//エラー画面出力
				$this->set('code', '232');
				$this->render('/errors/custom');
			//退会者の投稿へのコメントを論理削除
			} else if (!($this->Comment->updateAll(array('Comment.modified' => date("'Y-m-d H:i:s'"), 'Comment.deleted' => 1), array('Article.user_id' => $this->Auth->user('id'))))) {
				$this->User->rollback();
				$this->Request->rollback();
				$this->Article->rollback();
				//エラー画面出力
				$this->set('code', '233');
				$this->render('/errors/custom');
			//正常終了
			} else {
				$this->User->commit();
				$this->Request->commit();
				$this->Article->commit();
				//強制ログアウト
				$this->Auth->logout();
				//デフォルトレイアウト変更
				$this->layout = 'default';
				//完了画面出力
				$this->render('delete_end');
			}
		}
	}

}
?>