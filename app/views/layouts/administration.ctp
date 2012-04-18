<?= $facebook->html(); ?>
<?php $auth = $this->Session->read('Auth.User'); ?>
<head>
	<?php echo $html->charset()."\n"; ?>
	<title>Whisprr<?php echo (strcmp($title_for_layout, '') != 0) ? ' / '.$title_for_layout : ''; ?></title>
	<?php echo $html->meta('icon')."\n"; ?>
	<?php echo $html->css('style')."\n"; ?>
	<?php echo $scripts_for_layout."\n"; ?>
</head>
<body>
<div id="container">
	<div id="header">
		<div id="header_wrapper">
			<div id="logo">
				<h1><a href="/">Whisprr</a></h1>
			</div>
			<div id="header_nav">
				<?php if(!empty($auth)){ ?>
					<table><tr><td>
						<img src="/img/basic/leaves_32.png" />
					</td><td>
						<?php echo $facebook->logout(array('redirect'=>array('controller'=>'users', 'action'=>'logout'))); ?>
					</td></tr></table>
				<?php } ?>
			</div>
		</div>
	</div>
	<div id="wrapper">
<!-- START content -->
<?php
	$session->flash();
	echo $content_for_layout."\n";
?>
<!-- END content -->
	</div>
	<div id="footer"> 
		<?php echo $html->link('Copyright 2012 Whisprr', 'http://whisprr.com/', array('target'=>'_blank'), null, false)."\n"; ?>
	</div>
</div>
<?= $facebook->init(); ?>
</body>
</html>
