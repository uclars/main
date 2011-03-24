<?php
//### CREATE 2010/06/20 Pyon ###
	$this->pageTitle = '登録内容変更[確認]';
?>
<div class="users form">
	<?php echo $form->create(null, array('url' => array('action' => 'edit', 'id' => null)))."\n"; ?>
		<fieldset>
 			<legend><?php echo $this->pageTitle; ?></legend>
 			<dl>
<?php $i = 0; ?>
				<dt<?php echo (($i % 2 == 0) ? ' class="altrow"' : ''); ?>>表示名</dt>
				<dd<?php echo (($i++ % 2 == 0) ? ' class="altrow"' : '').'>'.((strcmp($data['User']['name'], '') != 0) ? h($data['User']['name']) : '&nbsp;'); ?></dd> 
				<dt<?php echo (($i % 2 == 0) ? ' class="altrow"' : ''); ?>>ログイン名</dt>
				<dd<?php echo (($i++ % 2 == 0) ? ' class="altrow"' : '').'>'.((strcmp($data['User']['username'], '') != 0) ? h($data['User']['username']) : '&nbsp;'); ?></dd> 
				<dt<?php echo (($i % 2 == 0) ? ' class="altrow"' : ''); ?>>パスワード</dt>
				<dd<?php echo (($i++ % 2 == 0) ? ' class="altrow"' : ''); ?>><?php echo ((strcmp($data['User']['password_new'], '') == 0) ? '(変更しない)' : '********'); ?></dd> 
			</dl>
		</fieldset>
		<div class="submit">
			<?php echo $form->input('id')."\n"; ?>
			<?php echo $form->input('name', array('type' => 'hidden'))."\n"; ?>
			<?php echo $form->input('username', array('type' => 'hidden'))."\n"; ?>
			<?php echo $form->input('password_new', array('type' => 'hidden'))."\n"; ?>
			<?php echo $form->input('password_chk', array('type' => 'hidden'))."\n"; ?>
			<?php echo $form->input('Request.id', array('type' => 'hidden'))."\n"; ?>
			<?php echo $form->submit('送信', array('div' => false)).'&nbsp;'.$form->submit('戻る', array('div' => false, 'name' => 'data[Back]'))."\n"; ?>
		</div>
	<?php echo $form->end()."\n"; ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link('ホーム', '/'); ?></li>
	</ul>
</div>