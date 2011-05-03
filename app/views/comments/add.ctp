<?php
$me_array = $this->Session->read('Auth.User');
$me = $me_array['id'];
$topicid = $topic_id;

echo $this->Form->create('Comment', array('controller'=>'comments', 'action' => 'add'));
echo $this->Form->hidden('topic_id',array('value'=>$topicid));
echo $this->Form->hidden('user_id',array('value'=>$me));
?>

<p>
<?php
	if($target_comment){
		echo $this->Form->text('body', array(
			'style' => 'width:500px; height:45px; font-size:1.5em; padding-top:3px;',
			'value' => ' Re: '.$target_comment 
		));
	}
	else{
		echo $this->Form->text('body', array(
			'style' => 'width:500px; height:45px; font-size:1.5em; padding-top:3px;'
		));
	}
?>
<?php echo $this->Form->end('GO'); ?>
</p>
<br />
<br />
</form>
