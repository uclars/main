<?php
//### CREATE 2010/06/20 Pyon ###
	$this->pageTitle = '投稿編集';
?>
<div class="articles form">
<?php if (isset($this->params['url']['redirect'])): ?>
	<?php echo $form->create(null, array('url' => array('action' => 'edit', 'id' => $data['Article']['id'], '?' => array('redirect' => $this->params['url']['redirect']))))."\n"; ?>
<?php else: ?>
	<?php echo $form->create('Article')."\n";?>
<?php endif; ?>
		<fieldset>
			<legend><?php echo $this->pageTitle; ?></legend>
			<?php echo $form->input('id')."\n"; ?>
			<?php echo $form->input('body', array('label' => '本文'))."\n"; ?>
		</fieldset>
		<div class="submit">
			<?php echo $form->input('Request.id', array('type' => 'hidden'))."\n"; ?>
			<?php echo $form->submit('確認', array('div' => false, 'name' => 'data[Check]')).'&nbsp;'.$form->submit('確認せずに送信', array('div' => false, 'name' => 'data[Next]'))."\n"; ?>
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