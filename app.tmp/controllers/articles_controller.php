<?php
//### CREATE 2010/06/20 Pyon ###
class ArticlesController extends AppController {

	var $name = 'Articles';
	var $helpers = array('Html', 'Form');
	var $uses = array('Article', 'User', 'Comment', 'Request');

	//### アクションが実行される前に実行 ###
	function beforeFilter() {
		//親クラス呼出
		parent::beforeFilter();
		//[Auth]例外設定
		$this->Auth->allow('index');
	}

	//### 投稿一覧 ###
	function index($user_id = null) {
		//引数チェック
		if ((!($user = $this->User->read(null, $user_id))) || ($user['User']['deleted'] != 0)) {
			//エラー画面出力
			$this->cakeError('error404');
		} else {
			//表示値セット
			$this->set('user', $user);
			//投稿データセット
			$this->Article->recursive = 0;
			$this->Article->bindModel(array(
				'hasOne' => array(
					'CommentArticle' => array(
						'className' => 'CommentArticle',
						'foreignKey' => 'article_id',
						'fields' => 'CommentArticle.Count',
						'type' => 'LEFT'
					)
				)
			), false);
			$this->paginate = array('order' => 'Article.id DESC');
			$this->set('datas', $this->paginate(array('Article.user_id' => $user_id, 'Article.deleted' => 0)));
			//重複登録対策(キー発行)
			if ($user_id == $this->Auth->user('id')) {
				$this->data['Request']['id'] = AppController::_getRequestId();
				if (strcmp($this->data['Request']['id'], '') == 0) {
					//エラー画面出力
					$this->set('code', '300');
					$this->render('/errors/custom');
				}
			}
		}
	}

	//### 新規投稿 ###
	function add() {
		//初回表示時
		if (empty($this->data)) {
			//重複登録対策(キー発行)
			$this->data['Request']['id'] = AppController::_getRequestId();
			if (strcmp($this->data['Request']['id'], '') == 0) {
				//エラー画面出力
				$this->set('code', '310');
				$this->render('/errors/custom');
			}
		//重複登録対策(キーチェック)
		} else if ($this->Request->find('count', array('conditions' => array('Request.id' => $this->data['Request']['id'], 'Request.deleted' => 0))) == 0) {
			//完了画面出力
			$this->render('add_end');
		//戻るボタン押下時
		} else if (!(empty($this->data['Back']))) {
		//送信ボタン押下時
		} else {
			//入力チェック
			$data = array();
			$data['Article']['body'] = $this->data['Article']['body'];
			$this->Article->create($data);
			if (!($this->Article->validates())) {
				$this->Session->setFlash('入力内容に誤りがあります。訂正してください。');
			} else {
				//表示値セット
				$this->set('data', $this->data);
				//確認画面出力
				if (!(empty($this->data['Check']))) {
					$this->render('add_chk');
				} else {
					//保存データ更新
					$data['Article']['user_id'] = $this->Auth->user('id');
					//重複登録対策(キー論理削除)
					$request = array();
					$request['Request']['id'] = $this->data['Request']['id'];
					$request['Request']['deleted'] = 1;
					//DB保存
					$this->Article->begin();
					$this->Request->begin();
					if ((!($this->Article->save($data, false))) || (!($this->Request->save($request, false)))) {
						$this->Article->rollback();
						$this->Request->rollback();
						//エラー画面出力
						$this->set('code', '311');
						$this->render('/errors/custom');
					} else {
						$this->Article->commit();
						$this->Request->commit();
						//完了画面を省略して遷移
						if (!(empty($this->data['Next']))) {
							$this->Session->setFlash('投稿が完了しました。');
							if ((isset($this->params['url']['redirect'])) && (strcmp($this->params['url']['redirect'], 'home') == 0)) {
								$this->redirect('/');
							} else {
								$this->redirect(array('action' => 'index', 'id' => $this->Auth->user('id')));
							}
						} else {
							//完了画面出力
							$this->render('add_end');
						}
					}
				}
			}
		}
	}

	//### 投稿編集 ###
	function edit($id = null) {
		//引数チェック
		if ((!($id)) || (!($article = $this->Article->read(null, $id))) || ($article['Article']['deleted'] != 0)) {
			//エラー画面出力
			$this->cakeError('error404');
		} else if ($article['Article']['user_id'] != $this->Auth->user('id')) {
			//エラー画面出力
			$this->set('msg', 'この投稿を変更する権限がありません。');
			$this->render('/errors/custom');
		//初回表示時
		} else if (empty($this->data)) {
			//初期値セット
			$this->data = $article;
			//表示値セット
			$this->set('data', $article);
			//重複登録対策(キー発行)
			$this->data['Request']['id'] = AppController::_getRequestId();
			if (strcmp($this->data['Request']['id'], '') == 0) {
				//エラー画面出力
				$this->set('code', '320');
				$this->render('/errors/custom');
			}
		//重複登録対策(キーチェック)
		} else if ($this->Request->find('count', array('conditions' => array('Request.id' => $this->data['Request']['id'], 'Request.deleted' => 0))) == 0) {
			//表示値セット
			$this->set('data', $this->data);
			//完了画面出力
			$this->render('edit_end');
		//戻るボタン押下時
		} else if (!(empty($this->data['Back']))) {
			//表示値セット
			$this->set('data', $article);
		//送信ボタン押下時
		} else {
			//入力チェック
			$data = array();
			$data['Article']['id'] = $id;
			$data['Article']['body'] = $this->data['Article']['body'];
			$this->Article->create($data);
			if (!($this->Article->validates())) {
				$this->Session->setFlash('入力内容に誤りがあります。訂正してください。');
			} else {
				//表示値セット
				$this->set('data', $this->data);
				//確認画面出力
				if (!(empty($this->data['Check']))) {
					$this->render('edit_chk');
				} else {
					//保存データ更新
					$data['Article']['user_id'] = $this->Auth->user('id');
					//重複登録対策(キー論理削除)
					$request = array();
					$request['Request']['id'] = $this->data['Request']['id'];
					$request['Request']['deleted'] = 1;
					//DB保存
					$this->Article->begin();
					$this->Request->begin();
					if ((!($this->Article->save($data, false))) || (!($this->Request->save($request, false)))) {
						$this->Article->rollback();
						$this->Request->rollback();
						//エラー画面出力
						$this->set('code', '321');
						$this->render('/errors/custom');
					} else {
						$this->User->commit();
						$this->Request->commit();
						//完了画面を省略して遷移
						if (!(empty($this->data['Next']))) {
							$this->Session->setFlash('編集が完了しました。');
							if (isset($this->params['url']['redirect'])) {
								if (strcmp($this->params['url']['redirect'], 'home') == 0) {
									$this->redirect('/');
								} else if (strcmp($this->params['url']['redirect'], 'comments') == 0) {
									$this->redirect(array('controller' => 'comments', 'action' => 'index', 'id' => $id));
								} else {
									$this->redirect(array('action' => 'index', 'id' => $this->Auth->user('id')));
								}
							} else {
								$this->redirect(array('action' => 'index', 'id' => $this->Auth->user('id')));
							}
						} else {
							//完了画面出力
							$this->render('edit_end');
						}
					}
				}
			}
		}
	}

	//### 投稿削除 ###
	function delete($id = null) {
		//引数チェック
		if ((!($id)) || (!($article = $this->Article->read(null, $id)))) {
			//エラー画面出力
			$this->cakeError('error404');
		} else if (strcmp($article['Article']['user_id'], $this->Auth->user('id')) != 0) {
			//エラー画面出力
			$this->set('msg', 'この投稿を削除する権限がありません。');
			$this->render('/errors/custom');
		} else {
			//表示値セット
			$this->set('data', $article);			
			//重複登録対策(キーチェック)
			if ((!(empty($this->data))) && ($this->Request->find('count', array('conditions' => array('Request.id' => $this->data['Request']['id'], 'Request.deleted' => 0))) == 0)) {
				//完了画面出力
				$this->render('delete_end');
			//論理削除チェック
			} else if ($article['Article']['deleted'] != 0) {
				//エラー画面出力
				$this->cakeError('error404');
			//初回表示時
			} else if (empty($this->data)) {
				//初期値セット
				$this->data = $article;
				//重複登録対策(キー発行)
				$this->data['Request']['id'] = AppController::_getRequestId();
				if (strcmp($this->data['Request']['id'], '') == 0) {
					//エラー画面出力
					$this->set('code', '330');
					$this->render('/errors/custom');
				}
			//送信ボタン押下時
			} else {
				//保存データ作成
				$data = array();
				$data['Article']['id'] = $id;
				$data['Article']['modified'] = date('Y-m-d H:i:s');	//バグ対応(更新されない)
				$data['Article']['deleted'] = 1;
				//重複登録対策(キー論理削除)
				$request = array();
				$request['Request']['id'] = $this->data['Request']['id'];
				$request['Request']['deleted'] = 1;
				//DB保存
				$this->Article->begin();
				$this->Request->begin();
				if ((!($this->Article->save($data, false))) || (!($this->Request->save($request, false)))) {
					$this->Article->rollback();
					$this->Request->rollback();
					//エラー画面出力
					$this->set('code', '331');
					$this->render('/errors/custom');
				//この投稿へのコメントを論理削除
				} else if (!($this->Comment->updateAll(array('Comment.modified' => date("'Y-m-d H:i:s'"), 'Comment.deleted' => 1), array('Comment.article_id' => $id)))) {
					$this->Article->rollback();
					$this->Request->rollback();
					//エラー画面出力
					$this->set('code', '332');
					$this->render('/errors/custom');
				//正常終了
				} else {
					$this->Article->commit();
					$this->Request->commit();
					//完了画面出力
					$this->render('delete_end');
				}
			}
		}
	}

}
?>