TOP
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
<td colspan="2"><?php echo h($post['Post']['body']); ?></td>
</tr>
<?php } ?>
</table>
