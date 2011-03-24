<?php
//### CREATE 2010/06/20 Pyon ###
	$this->pageTitle = 'エラー';
?>
<h2><?php echo $this->pageTitle; ?></h2>
<p class="error">
	<?php echo (isset($msg)) ? $msg : 'エラーが発生しました('.$code.')'; ?>
</p>
<div class="actions">
	<ul>
		<li><?php echo $html->link('ホーム', '/'); ?></li>
	</ul>
</div>