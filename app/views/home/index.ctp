<br />
<?php
echo "<div class='comment'>";
foreach($topics as $hottopic){
	echo "<div class='comment_pic'>";
		echo $html->image($hottopic['Master_categories']['url']);
	echo "</div>";
	echo "<div class='topic_body'>";
		echo $html->link($hottopic['Topic']['title'], array('controller'=>'topics', 'action'=>'show_topic', 'topicid'=>$hottopic['Topic']['id']))." ";
?>
		<div class='comment_following'>
			follower
			<span class='num'>
<?php
				///if there is number, show the nnum. if there is no number, show 0
				if(!empty($hottopic['Following_topic_numbers']['count'])){
					echo h($hottopic['Following_topic_numbers']['count']);
				}
				else{
					echo "0";
				}
?>
			</span>
			         | comments
			<span class='num'>
<?php
				///if there is number, show the nnum. if there is no number, show 0
				if(!empty($hottopic['Comment_topics']['Count'])){
					echo h($hottopic['Comment_topics']['Count']);
				}
				else{
					echo "0";
				}
?>
			</span>
		</div>
	</div>
	<div style='clear:both'></div>
	<br />
<?php
}
echo "</div>";

echo $paginator->prev('<< '.__('previous', true), array(), ' ', array('class'=>'disabled'));
echo $paginator->numbers();
echo $paginator->next(__('next', true).' >>', array(), ' ', array('class'=>'disabled'));

echo "<BR />";
?>
