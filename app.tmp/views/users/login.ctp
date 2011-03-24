<?php
//### CREATE 2010/06/20 Pyon ###
	$this->pageTitle = 'ログイン';
?>
<?php if ($session->check('Message.auth')) { $session->flash('auth'); echo "\n"; } ?>
<?php echo $form->create('User', array('action' => 'login'))."\n"; ?>
	<?php echo $form->input('username', array('label' => 'ログイン名'))."\n"; ?>
	<?php echo $form->input('password', array('label' => 'パスワード', 'maxlength' => 32))."\n"; ?>
<?php echo $form->end('ログイン')."\n"; ?>
<div class="actions">
	<ul>
		<li><?php echo $html->link('ホーム', '/'); ?></li>
	</ul>
</div>