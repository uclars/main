<?php
//### CREATE 2010/06/20 Pyon ###
	$this->pageTitle = 'コメント投稿[確認]';
?>
<div class="comments form">
	<?php echo $form->create(null, array('url' => array('action' => 'add', 'id' => $article['Article']['id'])))."\n"; ?>
		<fieldset>
 			<legend><?php echo $this->pageTitle; ?></legend>
			<dl>
<?php $i = 0; ?>
				<dt<?php echo (($i % 2 == 0) ? ' class="altrow"' : ''); ?>>本文</dt>
				<dd<?php echo (($i++ % 2 == 0) ? ' class="altrow"' : '').'>'.((strcmp($data['Comment']['body'], '') != 0) ? h($data['Comment']['body']) : '&nbsp;'); ?></dd> 
			</dl>
		</fieldset>
		<div class="submit">
			<?php echo $form->input('body', array('type' => 'hidden'))."\n"; ?>
			<?php echo $form->input('Request.id', array('type' => 'hidden'))."\n"; ?>
			<?php echo $form->submit('送信', array('div' => false)).'&nbsp;'.$form->submit('戻る', array('div' => false, 'name' => 'data[Back]'))."\n"; ?>
		</div>
	<?php echo $form->end()."\n"; ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link('ホーム', '/'); ?></li>
		<li><?php echo $html->link('投稿詳細', array('action' => 'index', 'id' => $article['Article']['id'])); ?></li>
	</ul>
</div>