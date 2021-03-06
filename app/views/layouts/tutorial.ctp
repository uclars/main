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
		function sf(){document.f.q.focus()}
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


<?php //var_dump($auth); ?>


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
		<div class="nav">
			<ul class="nl clearFix">
<?php
			if($phase==10){
?>
				<li class="active"><?php echo($html->link('hot topics', array('controller'=>'home', 'action'=>'index'))); ?></li>
				<li><?php echo($html->link('new topics', array('controller'=>'home', 'action'=>'index'))); ?></li>
				<li><?php echo($html->link('my topics', array('controller'=>'home', 'action'=>'index'))); ?></li>
<?php
			}
			elseif($phase==30){
?>
				<li><?php echo($html->link('hot topics', array('controller'=>'home', 'action'=>'index'))); ?></li>
				<li><?php echo($html->link('new topics', array('controller'=>'home', 'action'=>'index'))); ?></li>
				<li class="active"><?php echo($html->link('my topics', array('controller'=>'home', 'action'=>'index'))); ?></li>
<?php
			}
?>
			</ul>
		</div>
		<div style="clear:both"></div>
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
<?php
				echo $this->element('tutorial_description');
?>
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
