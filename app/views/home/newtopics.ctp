<br />
<?php /*if(!empty($auth)): ?>
<?php echo $this->Form->create('Topic', array('action' => 'add')); ?>
<p><?php echo $this->Form->text('body', array('style' => 'width:500px; height:45px; font-size:2em; padding-top:3px;')) ?>
<?php echo $this->Form->end('GO') ?></p>
</form>
<?php endif; */?>

<?php
	echo "<div class='comment'>";
foreach($topics as $newtopic) { 
	echo "<div class='comment_pic'>";
		echo $html->image($newtopic['Master_categories']['url']);
	echo "</div>";
	echo "<div class='topic_body'>";
		echo $html->link($newtopic['Topic']['title'], array('controller'=>'topics', 'action'=>'show_topic', 'topicid'=>$newtopic['Topic']['id']))." ";
	echo "<div class='comment_following'>";
	echo "follower ";
	echo "<span class='num'>";
	///if there is number, show the nnum. if there is no number, show 0
	if(!empty($newtopic['Following_topic_numbers']['count'])){
		 echo h($newtopic['Following_topic_numbers']['count']);
	}
	else{
		 echo "0";
	}
	echo " | comments ";
	        ///if there is number, show the nnum. if there is no number, show 0
        if(!empty($newtopic['Comment_topics']['Count'])){
                echo h($newtopic['Comment_topics']['Count']);
        }
        else{
                echo "0";
        }
	echo "</span>";
	echo "</div>";
	echo "</div>";
	echo "<div style='clear:both'></div>";
	echo "<br />";
} 
	echo "</div>";

echo $paginator->prev('<< '.__('previous', true), array(), ' ', array('class'=>'disabled'));
echo $paginator->numbers();
echo $paginator->next(__('next', true).' >>', array(), ' ', array('class'=>'disabled'))
?>
