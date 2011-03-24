<?php
//### CREATE 2010/06/20 Pyon ###
	$this->pageTitle = 'コメント削除';
?>
<div class="comments form">
	<?php echo $form->create(null, array('url' => array('action' => 'delete', 'id' => $data['Comment']['id'])))."\n"; ?>
		<fieldset>
 			<legend><?php echo $this->pageTitle; ?></legend>
 			<dl>
<?php $i = 0; ?>
				<dt<?php echo (($i % 2 == 0) ? ' class="altrow"' : ''); ?>>本文</dt>
				<dd<?php echo (($i++ % 2 == 0) ? ' class="altrow"' : '').'>'.((strcmp($data['Comment']['body'], '') != 0) ? h($data['Comment']['body']) : '&nbsp;'); ?></dd> 
			</dl>
		</fieldset>
		<?php echo $form->input('id')."\n"; ?>
		<?php echo $form->input('Request.id', array('type' => 'hidden'))."\n"; ?>
	<?php echo $form->end('送信')."\n"; ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link('ホーム', '/'); ?></li>
		<li><?php echo $html->link('投稿詳細', array('action' => 'index', 'id' => $data['Comment']['article_id'])); ?></li>
	</ul>
</div>