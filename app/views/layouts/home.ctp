<?= $facebook->html(); ?>
<head>
	<?php echo $html->charset()."\n"; ?>
	<title>YouXpress<?php echo (strcmp($title_for_layout, '') != 0) ? ' / '.$title_for_layout : ''; ?></title>
	<?php echo $html->meta('icon')."\n"; ?>
	<!--<?php echo $html->css('cake.generic')."\n"; ?>-->
	<?php echo $html->css('style')."\n"; ?>
	<?php echo $scripts_for_layout."\n"; ?>
</head>
<body>
<div id="container">
<!--		<h2>Join the information party, Express the best of you!</h2>  -->
	<div class="header-wrapper" style="margin:0px auto 0px auto;">
		<div style="width:auto; margin:0px auto 0px auto; text-align:left; padding:0px;">
			<div class="logo"><a href="/">YouXpress</a></div>
			<div class="float-right"> 
				<?php  if(!empty($auth)): ?>
					<div class="float-left right-margin" style="margin-top:3px;">
						Welocome! <?php echo($html->link(h($auth['username']),array('controller'=>'users',  'action'=>'show_users', 'id'=>h($auth['id'])))); ?>
						&nbsp;&nbsp;
						<?php echo $facebook->logout(array('redirect'=>array('controller'=>'users', 'action'=>'logout'))); ?>
					</div>
				<?php  else: ?>
                                        <div class="float-left right-margin" style="margin-top:3px;">
						<?php echo $facebook->login(); ?>
                                                &nbsp;&nbsp;
                                        </div>
				<?php  endif; ?>
			</div>
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
<?= $facebook->init(); ?>
</body>
</html>
