<br />
<?php /*if(!empty($auth)): ?>
<?php echo $this->Form->create('Topic', array('action' => 'add')); ?>
<p><?php echo $this->Form->text('body', array('style' => 'width:500px; height:45px; font-size:2em; padding-top:3px;')) ?>
<?php echo $this->Form->end('GO') ?></p>
</form>
<?php endif; */?>

<?php
foreach($timelines as $timeline) { 
?>
<div class="mainline">
	<div class="usericon">
<?php
	echo $this->Html->image(h($timeline['User']['profile_img']));
	/*
	echo $this->Html->image(h($topic['User']['profile_img']), array(
			'alt' => 'tavivit',
			'width' => '50px'
		)); 
	*/
?>
	<?php echo $html->link(h($timeline['User']['username']), array('controller'=>'users', 'action'=>'show_users', 'id'=>$timeline['Comment']['user_id'])); ?>
	</div>
	<div class="textdata">
	<?php echo $this->NiceNumber->getNiceTime(h($timeline['Comment']['created'])); ?>
<?php 
	echo h($timeline['Comment']['body']); 
?>
<?php
	echo $html->link(h($timeline['Topic']['title']), array('controller'=>'topics', 'action'=>'show_topic', 'topicid'=>$timeline['Topic']['id']));
?>
	</div>
</div>
<?php 
} 


echo $paginator->prev('<< '.__('previous', true), array(), ' ', array('class'=>'disabled'));
echo $paginator->numbers();
echo $paginator->next(__('next', true).' >>', array(), ' ', array('class'=>'disabled'))
?>
