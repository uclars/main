<FORM action='/administrations/comment' method='POST'>
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
	<TD ALIGN='left' style='border:solid 1px #333;'> id </TD>
	<TD style='border:solid 1px #333;'> body </TD>
	<TD style='border:solid 1px #333;'> topic ID </TD>
	<TD style='border:solid 1px #333;'> topic title </TD>
	<TD ALIGN='left' style='border:solid 1px #333;'> modified </TD>
	<TD ALIGN='left' style='border:solid 1px #333;'> deleted </TD>
	<TD ALIGN='left' style='border:solid 1px #333;'> checked </TD>
</TR>
<?php

foreach($comments as $commentdata){
echo "<TR>";
	echo "<TD ALIGN='left' style='border:solid 1px #333;'>".$html->link($commentdata['comments']['id'],array('controller'=>'administrations', 'action'=>'comment_detail', 'commentid'=>$commentdata['comments']['id']))."</TD>";
	echo "<TD style='border:solid 1px #333;'>";
	echo nl2br(h($commentdata['comments']['body']));
	echo"</TD>";
	echo "<TD style='border:solid 1px #333;'>".$commentdata['comments']['topic_id']."</TD>";
	echo "<TD style='border:solid 1px #333;'>".$topic_name[$commentdata['comments']['topic_id']]."</TD>";
	echo "<TD style='border:solid 1px #333;'>".$commentdata['comments']['modified']."</TD>";
	echo "<TD ALIGN='left' style='border:solid 1px #333;'>".$commentdata['comments']['deleted']."</TD>";
	echo "<TD ALIGN='left' style='border:solid 1px #333;'>".$commentdata['comments']['checked']."</TD>";
echo "</TR>";
}
?>
</TABLE>
