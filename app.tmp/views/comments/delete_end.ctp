<?php
//### CREATE 2010/06/20 Pyon ###
	$this->pageTitle = 'コメント削除[完了]';
?>
<div class="comments form">
	<h2><?php echo $this->pageTitle; ?></h2>
</div>
<div id="flashMessage" class="message">
	削除が完了しました。
</div>
<div class="actions">
	<ul>
		<li>
			<?php
				echo $form->create(null, array('url' => array('action' => 'index', 'id' => $data['Comment']['article_id'])));
				echo $form->end('投稿詳細');
			?>
		</li>
	</ul>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link('ホーム', '/'); ?></li>
	</ul>
</div>