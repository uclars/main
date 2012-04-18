<?= $facebook->html(); ?>
<?php $auth = $this->Session->read('Auth.User'); ?>
<head>
	<?php echo $html->charset()."\n"; ?>
	<title><?php echo $topictitle; ?> Whisprr</title>
	<!--<?php echo $html->css('cake.generic')."\n"; ?>-->
	<?php echo $html->css('style')."\n"; ?>
	<?php echo $scripts_for_layout."\n"; ?>
	<script type="text/javascript">
	<!--
		// count the letter users input
		function count(str){
			document.getElementById('message_count').innerHTML="<span>"+(500-str.length)+"</span>";
		}
	// -->
	</script>
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
<!--		<h2>Join the information party, Express the best of you!</h2>  -->
	<div id="header">
		<div id="header_wrapper">
			<div id="logo"><h1><a href="/">Whisprr</a></h1></div>
			<div id="header_nav">
			<?php if(!empty($auth)): ?>
				<table><tr><td>
					<img src="/img/basic/chair/chair_32.png" />
				</td><td>
					<?php echo($html->link('home', array('controller'=>'home',  'action'=>'index'))); ?>
				</td><td>
					<img src="/img/basic/casual_woman/casual_woman_32.png" /> 
				</td><td>
					<?php echo($html->link('profile', array('controller'=>'users',  'action'=>'show_users', 'id'=>h($auth['id'])))); ?>
				</td><td>
					<img src="/img/basic/leaves_32.png" />
				</td><td>
					<?php echo $facebook->logout(array('redirect'=>array('controller'=>'users', 'action'=>'logout'))); ?>
				</td></tr></table>
			<?php else: ?>
				<?php echo $facebook->login(); ?>
			<?php  endif; ?>
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
				<!-- <img src='/img/basic/park/park_192_words.png' wight=200 height=200/> -->
				<div class=createtopic>
				<?php echo $html->link('Create Topic', array('controller'=>'topics', 'action'=>'create')); ?>
				</div>
			</div>
			<div id="navigation">
				<div class="ntitle">Popular Topics</div>
				<ul>
					<?php echo $this->element('topic_ranking'); ?>
				</ul>
			</div>
		</div>
	</div>
	<div id="footer"> 
		<?php echo $html->link('Copyright 2012 Whisprr', 'http://whisprr.com/', array('target'=>'_blank'), null, false)."\n"; ?>
	</div>
</div>
<?= $facebook->init(); ?>
</body>
</html>
