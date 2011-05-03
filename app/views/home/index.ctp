<?php //echo $facebook->logout(); ?>

<br />
<?php /*if(!empty($auth)): ?>
<?php echo $this->Form->create('Topic', array('action' => 'add')); ?>
<p><?php echo $this->Form->text('body', array('style' => 'width:500px; height:45px; font-size:2em; padding-top:3px;')) ?>
<?php echo $this->Form->end('GO') ?></p>
</form>
<?php endif; */?>



<?php /* echo("<PRE>"); ?>
<?php var_dump($topic_list); ?>
<?php echo("</PRE>"); */?>



<table>
<?php
foreach($datas as $topic) { 
	if($topic_list){//if you have a topic list
		if(in_array($topic['Topic']['id'], $topic_list)){//show only your topic list
?>
<tr>
<td rowspan="4">
<?php
	echo $this->Html->image(h($topic['User']['profile_img']), array(
			'alt' => 'tavivit',
			'width' => '50px'
		)); 

?>
</td>
</tr>
<tr>
<td><?php echo $html->link(h($topic['User']['username']), array('controller'=>'users', 'action'=>'show_users', 'id'=>$topic['Comment']['user_id'])); ?></td>
<td><?php echo $this->NiceNumber->getNiceTime(h($topic['Comment']['created'])); ?></td>
</tr>
<tr>
 <td colspan="2">
<?php 
	echo h($topic['Comment']['body']); 
?>
 </td>
</tr>
<tr>
<td colspan="2">
<?php
	echo h($topic['Topic']['body']);
	if($topic_list){
		if(in_array($topic['Topic']['id'], $topic_list)){
        	        echo $html->link(' unfollow', array('controller'=>'followings', 'action'=>'action', 'do'=>'unfollow_topic', 'id'=>$topic['Topic']['id']));
		}else{
			echo $html->link(' follow', array('controller'=>'followings', 'action'=>'action', 'do'=>'follow_topic', 'id'=>$topic['Topic']['id']));
		}
	}
?>
</td>
</tr>
<?php 
		}//end of if(in_array)
	}//end of if(topic_list)
	else{//For non-login user




//		if($topic['Topic']['id']==1){//show category 1 for non-login user
?>
<tr>
<td rowspan="4"><?php echo $this->Html->image(h($topic['User']['profile_img'])); ?></td>
</tr>
<tr>
<td><?php echo $html->link(h($topic['User']['username']), array('controller'=>'users', 'action'=>'show_users', 'id'=>$topic['Comment']['user_id'])); ?></td>
<td><?php echo $this->NiceNumber->getNiceTime(h($topic['Comment']['created'])); ?></td>
</tr>
<tr>
 <td colspan="2">
<?php
        echo h($topic['Comment']['body']);
?>
 </td>
</tr>
<tr>
<td colspan="2">
<?php
        echo $html->link(h($topic['Topic']['body']), array('controller'=>'topics', 'action'=>'index', 'topicid'=>$topic['Topic']['id']));


/*  follow/unfollow link
        if($topic_list){
                if(in_array($topic['Topic']['id'], $topic_list)){
                        echo $html->link(' unfollow', array('controller'=>'followings', 'action'=>'action', 'do'=>'unfollow_topic', 'id'=>$topic['Topic']['id']))
;
                }else{
                        echo $html->link(' follow', array('controller'=>'followings', 'action'=>'action', 'do'=>'follow_topic', 'id'=>$topic['Topic']['id']));
                }
        }
*/


?>
</td>
</tr>
<?php


//		}




	}
} 
?>
</table>
