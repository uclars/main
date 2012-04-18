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

<FORM action='/administrations/modify' method='POST'>
<TABLE>
<?php
$id=$item_array['id'];
$user_id=$item_array['user_id'];
$title=$item_array['title'];
$body=$item_array['body'];
$category=$item_array['category'];
$hide=$item_array['hide'];
$deleted=$item_array['deleted'];


echo "<TR><TD colspan='4'>";
	echo "<input type='text' name='title' value='";
	echo h($title);
	echo "' size='75' style='font-size:1.3em;'><br />";
echo "</TD></TR>";
echo "<TR><TD colspan='4'>";
	echo "<textarea name='body' rows='15' cols='80' style='font-size:1.3em;'>";
	echo $body;
	echo "</textarea>";
echo "</TD></TR>";
echo "<TR><TD>";
	echo "user id:<input type='text' name='user_id' value='".$user_id."' size='5' style='font-size:2em;'>";
echo "</TD><TD>";
	echo "category:<input type='text' name='category' value='".$category."' size='5' style='font-size:2em;'>";
echo "</TD><TD>";
	echo "hide:<input type='text' name='hide' value='".$hide."' size='5' style='font-size:2em;'>";
echo "</TD><TD>";
	echo "deleted:<input type='text' name='deleted' value='".$deleted."' size='5' style='font-size:2em;'>";
echo "</TD></TR>";

echo "<input type='hidden' name='id' value='".$id."' >";
echo "<input type='hidden' name='type' value='topic' >";
echo "<br />";
echo "<br />";
?>
<input type='submit' value='SUBMIT'>
</TABLE>
</FORM>
