<?php
//### CREATE 2010/06/20 Pyon ###
	$this->pageTitle = '退会';
?>
<div class="users form">
	<?php echo $form->create(null, array('url' => array('action' => 'delete', 'id' => null)))."\n"; ?>
		<fieldset>
 			<legend><?php echo $this->pageTitle; ?></legend>
 			<dl>
<?php $i = 0; ?>
				<dt<?php echo (($i % 2 == 0) ? ' class="altrow"' : ''); ?>>表示名</dt>
				<dd<?php echo (($i++ % 2 == 0) ? ' class="altrow"' : '').'>'.((strcmp($auth['User']['name'], '') != 0) ? h($auth['User']['name']) : '&nbsp;'); ?></dd> 
				<dt<?php echo (($i % 2 == 0) ? ' class="altrow"' : ''); ?>>ログイン名</dt>
				<dd<?php echo (($i++ % 2 == 0) ? ' class="altrow"' : '').'>'.((strcmp($auth['User']['username'], '') != 0) ? h($auth['User']['username']) : '&nbsp;'); ?></dd> 
				<dt<?php echo (($i % 2 == 0) ? ' class="altrow"' : ''); ?>>パスワード</dt>
				<dd<?php echo (($i++ % 2 == 0) ? ' class="altrow"' : ''); ?>>********</dd> 
			</dl>
		</fieldset>
		<?php echo $form->input('id')."\n"; ?>
		<?php echo $form->input('Request.id', array('type' => 'hidden'))."\n"; ?>
	<?php echo $form->end('送信')."\n"; ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link('ホーム', '/'); ?></li>
	</ul>
</div>