<?php
//### CREATE 2010/06/20 Pyon ###
	$this->pageTitle = '新規登録';
?>
<div class="users form">
	<?php echo $form->create('User')."\n"; ?>
		<fieldset>
			<legend><?php echo $this->pageTitle; ?></legend>
			<?php echo $form->input('name', array('label' => '表示名'))."\n"; ?>
			<?php echo $form->input('username', array('label' => 'ログイン名'))."\n"; ?>
			<?php echo $form->input('password_new', array('label' => 'パスワード', 'type' => 'password', 'maxlength' => 32))."\n"; ?>
			<?php echo $form->input('password_chk', array('label' => 'パスワード(再入力)', 'type' => 'password', 'maxlength' => 32))."\n"; ?>
		</fieldset>
		<div class="submit">
			<?php echo $form->input('Request.id', array('type' => 'hidden'))."\n"; ?>
			<?php echo $form->submit('確認', array('div' => false, 'name' => 'data[Check]')).'&nbsp;'.$form->submit('確認せずに送信', array('div' => false))."\n"; ?>
		</div>
	<?php echo $form->end()."\n"; ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link('ホーム', '/'); ?></li>
	</ul>
</div>