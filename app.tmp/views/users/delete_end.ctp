<?php
//### CREATE 2010/06/20 Pyon ###
	$this->pageTitle = '退会[完了]';
?>
<div class="users form">
	<h2><?php echo $this->pageTitle; ?></h2>
</div>
<div id="flashMessage" class="message">
	退会が完了しました。
</div>
<div class="actions">
	<ul>
		<li>
			<?php echo $form->create(null, array('url' => '/'))."\n"; ?>
			<?php echo $form->end('ホーム')."\n"; ?>
		</li>
	</ul>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link('ホーム', '/'); ?></li>
	</ul>
</div>