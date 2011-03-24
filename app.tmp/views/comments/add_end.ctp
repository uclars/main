<?php
//### CREATE 2010/06/20 Pyon ###
	$this->pageTitle = 'コメント投稿[完了]';
?>
<div class="articles form">
	<h2><?php echo $this->pageTitle; ?></h2>
</div>
<div id="flashMessage" class="message">
	投稿が完了しました。
</div>
<div class="actions">
	<ul>
		<li>
			<?php echo $form->create(null, array('url' => array('action' => 'index', 'id' => $article['Article']['id'])))."\n"; ?>
			<?php echo $form->end('投稿詳細')."\n"; ?>
		</li>
	</ul>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link('ホーム', '/'); ?></li>
	</ul>
</div>