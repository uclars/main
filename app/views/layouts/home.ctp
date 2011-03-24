<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php echo $html->charset()."\n"; ?>
	<title>ミニブログ<?php echo (strcmp($title_for_layout, '') != 0) ? ' / '.$title_for_layout : ''; ?></title>
	<?php echo $html->meta('icon')."\n"; ?>
	<!--<?php echo $html->css('cake.generic')."\n"; ?>-->
	<?php echo $html->css('style')."\n"; ?>
	<?php echo $scripts_for_layout."\n"; ?>
</head>
<body>
<div id="top">
	<div id="header">
		<?php echo $html->image("YouXpress_logo.png", array("alt"=>"テスト")) ?>
		<h4>
<?php if(isset($auth)): ?>
	Welocome! <?php echo h($auth['User']['name']); ?> <?php echo $html->link('[logout', array('controller'=>'users', 'action'=>'logout')); ?>
<?php else: ?>
	<?php echo $html->link('[register]', array('controller'=>'users', 'action'=>'add')).' '.$html->link('[login]', array('controller'=>'users', 'action'=>'login')); ?>
<?php endif; ?>
		</h4>
		<p>Join the information party, Express the best of you!</p>
	</div>
	<div id="contents">
		<div id="main">
<!-- START content -->
<?php
	$session->flash();
	echo $content_for_layout."\n";
?>
<!-- END content -->
		</div>
	</div>
	<div id="footer">
			<?php echo $html->link('Copyright 2011 YouXpress', 'http://www.youxpress.com/', array('target'=>'_blank'), null, false)."\n"; ?>
	</div>
</div>
<?php if (Configure::read('debug') > 0): ?>
<!-- START debug -->
<?php echo $cakeDebug."\n"; ?>
<?php if (Configure::read('debug') == 3): ?>
<div id="cookieDump">
	<h2>Cookie dump:</h2>
	<pre><?php
		ob_start();
		var_dump($_COOKIE);
		$text = ob_get_contents();
		ob_end_clean();
		echo h($text);
	?></pre>
</div>
<div id="sessionDump">
	<h2>Session dump:</h2>
	<pre><?php
		ob_start();
		var_dump($_SESSION);
		$text = ob_get_contents();
		ob_end_clean();
		echo h($text);
	?></pre>
</div>
<?php endif; ?>
<!-- END debug -->
<?php endif; ?>
</body>
</html>
