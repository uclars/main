<PRE>
<?php
$referrer = $html->action;

//if topiclist page, show the random list
if($referrer != "topiccatlist"){
	echo $html->link($first['title'], array('controller'=>'topics','action'=>'show_topic','topicid'=>$first['id']));
	echo "<br />";
	echo " ";
	echo "<br />";
	echo $html->link($second['title'], array('controller'=>'topics','action'=>'show_topic','topicid'=>$second['id']));
	echo "<br />";
	echo " ";
        echo "<br />";
	echo $html->link($third['title'], array('controller'=>'topics','action'=>'show_topic','topicid'=>$third['id']));
	echo "<br />";
	echo " ";
        echo "<br />";
	echo $html->link($forth['title'], array('controller'=>'topics','action'=>'show_topic','topicid'=>$forth['id']));
	echo "<br />";
	echo " ";
        echo "<br />";
	echo $html->link($fifth['title'], array('controller'=>'topics','action'=>'show_topic','topicid'=>$fifth['id']));
	echo "<br />";
	echo "<br />";
}
?>
</PRE>
