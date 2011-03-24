<?php
//### CREATE 2010/06/20 Pyon ###
	$this->pageTitle = 'コメント投稿';
?>
<div class="comments form">
	<?php echo $form->create(null, array('url' => array('action' => 'add', 'id' => $article['Article']['id'])))."\n"; ?>
		<fieldset>
			<legend><?php echo $this->pageTitle; ?></legend>
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
		<li><?php echo $html->link('投稿詳細', array('action' => 'index', 'id' => $article['Article']['id'])); ?></li>
	</ul>
</div>