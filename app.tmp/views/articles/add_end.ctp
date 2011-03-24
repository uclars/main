<?php
//### CREATE 2010/06/20 Pyon ###
	$this->pageTitle = '新規投稿[完了]';
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
<?php if ((isset($this->params['url']['redirect'])) && (strcmp($this->params['url']['redirect'], 'home') == 0)): ?>
			<?php echo $form->create(null, array('url' => '/'))."\n"; ?>
			<?php echo $form->end('ホーム')."\n"; ?>
<?php else: ?>
			<?php echo $form->create(null, array('url' => array('action' => 'index', 'id' => $auth['User']['id'])))."\n"; ?>
			<?php echo $form->end('投稿一覧')."\n"; ?>
<?php endif; ?>
		</li>
	</ul>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link('ホーム', '/'); ?></li>
		<li><?php echo $html->link('投稿一覧', array('action' => 'index', 'id' => $auth['User']['id'])); ?></li>
	</ul>
</div>