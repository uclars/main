<?php if(!empty($auth)): ?>
<?php echo $this->Form->create('Post', array('action' => 'add')); ?>
<p><?php echo $this->Form->text('body', array('style' => 'width:500px; height:45px; font-size:2em; padding-top:3px;')) ?>
<?php echo $this->Form->end('GO') ?></p>
</form>
<?php endif; ?>
<table>
<?php foreach($posts as $post) { ?>
<tr>
<td rowspan="3"><?php echo $this->Html->image(h($post['User']['profile_img'])); ?></td>
</tr>
<tr>
<td><?php echo $html->link(h($post['User']['username']), array('controller'=>'users', 'action'=>'show_users')); ?></td>
<td><?php echo h($post['Post']['created']); ?></td>
</tr>
<tr>
<td colspan="2">
<?php

	echo h($post['Post']['body']);
	if(in_array($post['Post']['id'], $post_list)){
                echo $html->link(' unfollow', array('controller'=>'followings', 'action'=>'action', 'do'=>'unfollow_post', 'id'=>$post['Post']['id']));
	}else{
		echo $html->link(' follow', array('controller'=>'followings', 'action'=>'action', 'do'=>'follow_post', 'id'=>$post['Post']['id']));
	}
?>
</td>
</tr>
<?php } ?>
</table>
