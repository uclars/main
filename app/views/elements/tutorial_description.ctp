<?php
switch($sidebar){
	case 10:
		echo "<div id='navigation_wrapper'>";
			echo "<div id='navigation'>";
				echo "<div class=ntitle>Follow Topic</div>";
				echo "<pre>whisprr is a web forum which has many kinds of topics.</pre>";
				echo "<pre>You can follow topics you get interested.</pre>";
				echo "<pre>Let's follow a topic</pre>";
			echo "</div>";
		echo "</div>";
		break;
	case 20:
		echo "<div id='navigation_wrapper'>";
			echo "<div id='navigation'>";
				echo "<div class=ntitle>Follow Topic</div>";
				echo "<pre>Now you see the timeline of the the topic \"Where are you from?\"</pre>";
				echo "<pre>Click the 「<span style='color:#e47a1a;'>follow</span>」button to follow this topic.</pre>";
			echo "</div>";
		echo "</div>";
		break;
	case 30:
		echo "<div id='navigation_wrapper'>";
			echo "<div id='navigation'>";
				echo "<div class=ntitle>Follow Topic</div>";
				//echo "<pre>Click the topic \"<span style='background: #f7376b; color: #fff'>Where are you from?</span>\"</pre>";
				echo "<pre>Once you follow a topic, it is shown under the \"my topics\" tab.</pre>";
				echo "<pre>Now comment on the board!</pre>";
				echo "<pre>But before that, register your name. Click <span style='font-size:25px;'>";
				echo $html->link('here', array('controller'=>'tutorials', 'action'=>'phase',30,1));
				echo "</span></pre>";
			echo "</div>";
		echo "</div>";
		break;
////  ------------- not used til 60  -------------------///
	case 40:
		echo "<div id='navigation_wrapper'>";
			echo "<div id='navigation'>";
				echo "<div class=ntitle>Follow User</div>";
				echo "<pre>now, you can follow users, too.</pre>";
				echo "<pre>click my name and go to my profie page.</pre>";
			echo "</div>";
		echo "</div>";
		break;
	case 50:
		echo "<div id='navigation_wrapper'>";
			echo "<div id='navigation'>";
				echo "<div class=ntitle>Follow User</div>";
				echo "<pre>click \"<span style='background:  #f7376b; color: #fff'>follow</span>\" link below my name.</pre>";
			echo "</div>";
		echo "</div>";
		break;
////  ------------------------------------------------ ///
	case 60:
		echo "<div id='navigation_wrapper'>";
			echo "<div id='navigation'>";
				echo "<div class=ntitle>Choose User Name</div>";
				echo "<pre>Input your user name.</pre>";
				echo "<pre>Choose your user name carefuly because <span style='font-size:16px; font-weight:bold;'>you can't change it once you've decided</span>.</pre>";
			echo "</div>";
		echo "</div>";
		break;
	case 70:
		echo "<div id='navigation_wrapper'>";
			echo "<div id='navigation'>";
				echo "<div class=ntitle>WECOME</div>";
				echo "<pre>Welcome to Whisprr, $username!</pre>";
				echo "<br />";
				echo "<pre>Next, click the link below to comment on the topic.</pre>";
				echo "<pre><span style='font-size:21px;'>";
				echo $html->link('comment on the topic', array('controller'=>'tutorials', 'action'=>'phase', 70, 1));
				echo "</span></pre>";
				/*  in case of PERSONAL TEST
				echo "<div class=ntitle>What's your type</div>";
				echo "<pre>Welcome to Whisprr, $username!</pre>";
				echo "<br />";
				echo "<pre>Next, click the link below to see what is your type.</pre>";
				echo $html->link('go pic my type', array('controller'=>'tutorials', 'action'=>'phase', 70, 1));
				*/
			echo "</div>";
		echo "</div>";
		break;
	case 80:
		echo "<div id='navigation_wrapper'>";
			echo "<div id='navigation'>";
				echo "<div class=ntitle>What's your type</div>";
				echo "<pre>Which sentence describes you the most?</pre>";
				echo "<pre>Pic one and see what type you belong to.</pre>";
				echo "<pre>There are 7 types and they are represented as cute dogs.</pre>";
				echo "<table align='left'>";
				foreach($avator_array as $avats){
					echo "<tr><td><img src='".$avats['MasterAvator']['url32']."' /></td><td>".$avats['MasterAvator']['name']."</td></tr>";
				}
				echo "</table>";
			echo "</div>";
		 echo "</div>";
		break;
	case 81:
		echo "<div id='navigation_wrapper'>";
			echo "<div id='navigation'>";
				echo "<div class=ntitle>What's your type</div>";
				echo "<pre>Now you know your type.</pre>";
				echo "<pre>Next, you write a comment on the \"Where are you from\" topic.</pre>";
				echo "<h2>".$html->link('put a comment', array('controller'=>'tutorials', 'action'=>'phase', 81, 1))."</h2>";
			echo "</div>";
		echo "</div>";
		break;
	case 90:
		echo "<div id='navigation_wrapper'>";
			echo "<div id='navigation'>";
				echo "<div class=ntitle>Comment on the Topic</div>";
				echo "<pre>Let's put your place on 'Where are you from?' topic.</pre>";
			echo "</div>";
		echo "</div>";
		break;
	case 100:
		echo "<div id='navigation_wrapper'>";
			echo "<div id='navigation'>";
				echo "<div class=ntitle>Congraturations!!</div>";
				echo "<pre>you've just completed the tutorial.</pre>";
				echo "<pre>now go to your home page, and enjoy this serivce!</pre>";
			echo "</div>";
		echo "</div>";
		echo  "<h3>".$html->link('go to main page', array('controller'=>'tutorials', 'action' => 'phase', 100, 1))."</h3>";
		break;

}
?>
