<FORM action='/administrations/topic' method='POST'>
<TABLE>
	<TR><TD>
		User name:<input name='user_name' type='text' size='5' style='font-size:1.5em;'>
	</TD></TR>
	<TR><TD>
		start:<input name='start_date' type='text' size='10' style='font-size:1.5em;'> - end:<input name='end_date' type='text' size='10' style='font-size:1.5em;'>
	</TD></TR>
	<TR><TD>
		Date (ex. 2011-05-06 ~ 2011-11-02)
	</TD></TR>
</TABLE>
<input type='submit' value=' SEARCH '>
</FORM>

<TABLE width='100%' style='border:solid 2px #333;'>
<TR>
	<TD ROWSPAN='2' ALIGN='left' style='border:solid 1px #333;'> id </TD>
	<TD style='border:solid 1px #333;'> title </TD>
	<TD ROWSPAN='2' ALIGN='left' style='border:solid 1px #333;'> modified </TD>
	<TD ROWSPAN='2' ALIGN='left' style='border:solid 1px #333;'> deleted </TD>
	<TD ROWSPAN='2' ALIGN='left' style='border:solid 1px #333;'> checked </TD>
</TR>
<TR>
	<TD style='border:solid 1px #333;'> body </TD>
</TR>
<?php
foreach($topics as $topicdata){
echo "<TR>";
	echo "<TD ROWSPAN='2' ALIGN='left' style='border:solid 1px #333;'>".$topicdata['topics']['id']."</TD>";
	echo "<TD style='border:solid 1px #333;'>";
	echo $html->link($topicdata['topics']['title'],array('controller'=>'administrations', 'action'=>'topic_detail', 'topicid'=>$topicdata['topics']['id']));
	echo"</TD>";
	echo "<TD ROWSPAN='2' ALIGN='left' style='border:solid 1px #333;'>".$topicdata['topics']['modified']."</TD>";
	echo "<TD ROWSPAN='2' ALIGN='left' style='border:solid 1px #333;'>".$topicdata['topics']['deleted']."</TD>";
	echo "<TD ROWSPAN='2' ALIGN='left' style='border:solid 1px #333;'>".$topicdata['topics']['checked']."</TD>";
echo "</TR>";
echo "<TR width=100%>";
	echo "<TD style='border:solid 1px #333;'>".nl2br(h($topicdata['topics']['body']))."</TD>";
echo "</TR>";
}
?>
</TABLE>
