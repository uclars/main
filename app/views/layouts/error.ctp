<?= $facebook->html(); ?>
<?php $auth = $this->Session->read('Auth.User'); ?>
<head>
	<?php echo $html->charset()."\n"; ?>
	<title>Whisprr<?php echo (strcmp($title_for_layout, '') != 0) ? ' / '.$title_for_layout : ''; ?></title>
	<?php echo $html->meta('icon')."\n"; ?>
	<?php echo $html->css('style')."\n"; ?>
	<?php echo $scripts_for_layout."\n"; ?>
	<script>
		//focus when page load
		//function sf(){document.f.q.focus()}
	</script>
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-27637475-1']);
	  _gaq.push(['_setDomainName', 'whisprr.com']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

</script>
</head>
<body onload="sf();">
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
		<div id="content">
<!-- START content -->
<?php
	$session->flash();
	echo $content_for_layout."\n";
?>
<!-- END content -->
		</div>
       		<div id="navigation_wrapper">
                        <div id="navigation">
                        </div>
        	</div>
	</div>
	<div id="footer"> 
		<?php echo $html->link('Copyright 2011 Whisprr', 'http://whisprr.com/', array('target'=>'_blank'), null, false)."\n"; ?>
	</div>
</div>
<?= $facebook->init(); ?>
</body>
</html>
