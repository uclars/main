<?php
//### CREATE 2010/06/20 Pyon ###
class CommentsController extends AppController {

	var $name = 'Comments';
	var $helpers = array('Html', 'Form');
	var $uses = array('Comment', 'Article', 'Request');

	//### アクションが実行される前に実行 ###
	function beforeFilter() {
		//親クラス呼出
		parent::beforeFilter();
		//[Auth]例外設定
		$this->Auth->allow('index');
	}

	//### 投稿詳細 ###
	function index($article_id = null) {
		//引数チェック
		if ((!($article_id)) || (!($article = $this->Article->read(null, $article_id))) || ($article['Article']['deleted'] != 0)) {
			//エラー画面出力
			$this->cakeError('error404');
		} else {
			//表示値セット
			$this->set('article', $article);
			//コメントデータセット
			$this->Comment->recursive = 0;
			$this->paginate = array('order' => 'Comment.id');
			$this->set('datas', $this->paginate(array('Comment.article_id' => $article_id, 'Comment.deleted' => 0)));
			//重複登録対策(キー発行)
			$this->data['Request']['id'] = AppController::_getRequestId();
			if (strcmp($this->data['Request']['id'], '') == 0) {
				//エラー画面出力
				$this->set('code', '400');
				$this->render('/errors/custom');
			}
		}
	}

	//### コメント投稿 ###
	function add($article_id = null) {
		//引数チェック
		if ((!($article_id)) || (!($article = $this->Article->read(null, $article_id))) || ($article['Article']['deleted'] != 0)) {
			//エラー画面出力
			$this->cakeError('error404');
		} else {
			//表示値セット
			$this->set('article', $article);
			//初回表示時
			if (empty($this->data)) {
				//重複登録対策(キー発行)
				$this->data['Request']['id'] = AppController::_getRequestId();
				if (strcmp($this->data['Request']['id'], '') == 0) {
					//エラー画面出力
					$this->set('code', '410');
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
				$data['Comment']['body'] = $this->data['Comment']['body'];
				$this->Comment->create($data);
				if (!($this->Comment->validates())) {
					$this->Session->setFlash('入力内容に誤りがあります。訂正してください。');
				} else {
					//表示値セット
					$this->set('data', $this->data);
					//確認画面出力
					if (!(empty($this->data['Check']))) {
						$this->render('add_chk');
					} else {
						//保存データ更新
						$data['Comment']['user_id'] = $this->Auth->user('id');
						$data['Comment']['article_id'] = $article_id;
						//重複登録対策(キー論理削除)
						$request = array();
						$request['Request']['id'] = $this->data['Request']['id'];
						$request['Request']['deleted'] = 1;
						//DB保存
						$this->Comment->begin();
						$this->Request->begin();
						if ((!($this->Comment->save($data, false))) || (!($this->Request->save($request, false)))) {
							$this->Comment->rollback();
							$this->Request->rollback();
							//エラー画面出力
							$this->set('code', '411');
							$this->render('/errors/custom');
						} else {
							$this->Comment->commit();
							$this->Request->commit();
							//完了画面を省略して投稿詳細に遷移
							if (!(empty($this->data['Next']))) {
								$this->Session->setFlash('投稿が完了しました。');
								$this->redirect(array('action' => 'index', 'id' => $article['Article']['id']));
							} else {
								//完了画面出力
								$this->render('add_end');
							}
						}
					}
				}
			}
		}
	}

	//### コメント削除 ###
	function delete($id = null) {
		//引数チェック
		if ((!($id)) || (!($comment = $this->Comment->read(null, $id)))) {
			//エラー画面出力
			$this->cakeError('error404');
		} else if (($comment['Comment']['user_id'] != $this->Auth->user('id')) && ($comment['Article']['user_id'] != $this->Auth->user('id'))) {
			//エラー画面出力
			$this->set('msg', 'このコメントを削除する権限がありません。');
			$this->render('/errors/custom');
		} else {
			//表示値セット
			$this->set('data', $comment);
			//重複登録対策(キーチェック)
			if ((!(empty($this->data))) && ($this->Request->find('count', array('conditions' => array('Request.id' => $this->data['Request']['id'], 'Request.deleted' => 0))) == 0)) {
				//完了画面出力
				$this->render('delete_end');
			//論理削除チェック
			} else if ($comment['Comment']['deleted'] != 0) {
				//エラー画面出力
				$this->cakeError('error404');
				//初回表示時
			} else if (empty($this->data)) {
				//初期値セット
				$this->data = $comment;
				//重複登録対策(キー発行)
				$this->data['Request']['id'] = AppController::_getRequestId();
				if (strcmp($this->data['Request']['id'], '') == 0) {
					//エラー画面出力
					$this->set('code', '430');
					$this->render('/errors/custom');
				}
			//送信ボタン押下時
			} else {
				//保存データ作成
				$data = array();
				$data['Comment']['id'] = $id;
				$data['Comment']['modified'] = date('Y-m-d H:i:s');	//バグ対応(更新されない)
				$data['Comment']['deleted'] = 1;
				//重複登録対策(キー論理削除)
				$request = array();
				$request['Request']['id'] = $this->data['Request']['id'];
				$request['Request']['deleted'] = 1;
				//DB保存
				$this->Comment->begin();
				$this->Request->begin();
				if ((!($this->Comment->save($data, false))) || (!($this->Request->save($request, false)))) {
					$this->Comment->rollback();
					$this->Request->rollback();
					//エラー画面出力
					$this->set('code', '431');
					$this->render('/errors/custom');
				//正常終了
				} else {
					$this->Comment->commit();
					$this->Request->commit();
					//完了画面出力
					$this->render('delete_end');
				}
			}
		}
	}

}
?>