<?php
//### CREATE 2010/06/20 Pyon ###
	$this->pageTitle = '投稿編集[確認]';
?>
<div class="articles form">
<?php if (isset($this->params['url']['redirect'])): ?>
	<?php echo $form->create(null, array('url' => array('action' => 'edit', 'id' => $data['Article']['id'], '?' => array('redirect' => $this->params['url']['redirect']))))."\n"; ?>
<?php else: ?>
	<?php echo $form->create('Article')."\n";?>
<?php endif; ?>
		<fieldset>
 			<legend><?php echo $this->pageTitle; ?></legend>
			<dl>
<?php $i = 0; ?>
				<dt<?php echo (($i % 2 == 0) ? ' class="altrow"' : ''); ?>>本文</dt>
				<dd<?php echo (($i++ % 2 == 0) ? ' class="altrow"' : '').'>'.((strcmp($data['Article']['body'], '') != 0) ? h($data['Article']['body']) : '&nbsp;'); ?></dd> 
			</dl>
		</fieldset>
		<div class="submit">
			<?php echo $form->input('id')."\n"; ?>
			<?php echo $form->input('body', array('type' => 'hidden'))."\n"; ?>
			<?php echo $form->input('Request.id', array('type' => 'hidden'))."\n"; ?>
			<?php echo $form->submit('送信', array('div' => false)).'&nbsp;'.$form->submit('戻る', array('div' => false, 'name' => 'data[Back]'))."\n"; ?>
		</div>
	<?php echo $form->end()."\n"; ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link('ホーム', '/'); ?></li>
		<li><?php echo $html->link('投稿一覧', array('action' => 'index', $auth['User']['id'])); ?></li>
		<li><?php echo $html->link('投稿詳細', array('controller' => 'comments', 'action' => 'index', 'id' => $data['Article']['id'])); ?></li>
	</ul>
</div>