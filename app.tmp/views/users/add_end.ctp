<?php
//### CREATE 2010/06/20 Pyon ###
	$this->pageTitle = '新規登録[完了]';
?>
<div class="users form">
	<h2><?php echo $this->pageTitle; ?></h2>
</div>
<div id="flashMessage" class="message">
	登録が完了しました。
</div>
<div class="actions">
	<ul>
		<li>
			<?php echo $form->create('User', array('action' => 'login'))."\n"; ?>
				<?php echo $form->input('username', array('type' => 'hidden'))."\n"; ?>
				<?php echo $form->input('password', array('type' => 'hidden'))."\n"; ?>
			<?php echo $form->end('ログイン')."\n"; ?>
		</li>
	</ul>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link('ホーム', '/'); ?></li>
	</ul>
</div>