<?php
//### CREATE 2010/06/20 Pyon ###
	$this->pageTitle = 'Not found';
?>
<h2><?php echo $this->pageTitle; ?></h2>
<p class="error">
	ページが見つかりません。
</p>
<div class="actions">
	<ul>
		<li><?php echo $html->link('ホーム', '/'); ?></li>
	</ul>
</div>