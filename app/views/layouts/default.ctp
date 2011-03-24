<?php
//### CREATE 2010/06/20 Pyon ###
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset()."\n"; ?>
	<title>ミニブログ<?php echo (strcmp($title_for_layout, '') != 0) ? ' / '.$title_for_layout : ''; ?></title>
	<?php echo $html->meta('icon')."\n"; ?>
	<?php echo $html->css('cake.generic')."\n"; ?>
	<?php echo $scripts_for_layout."\n"; ?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $html->link('ミニブログ', '/'); ?></h1>
			<div id="action">
<?php if (isset($auth)): ?>
				ようこそ、<?php echo h($auth['User']['name']); ?>さん <?php echo $html->link('[ログアウト]', array('controller'=>'users', 'action'=>'logout'))."\n"; ?>
<?php else: ?>
				<?php echo $html->link('[新規登録]', array('controller'=>'users', 'action'=>'add')).' '.$html->link('[ログイン]', array('controller'=>'users', 'action'=>'login'))."\n"; ?>
<?php endif; ?>
			</div>
		</div>
		<div id="content">
<!-- START content -->
<?php
	$session->flash();
	echo $content_for_layout."\n";
?>
<!-- END content -->
		</div>
		<div id="footer">
			<?php echo $html->link('Copyrightc 2010 Night Only Project.', 'http://www.nightonly.com/', array('target'=>'_blank'), null, false)."\n"; ?>
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
