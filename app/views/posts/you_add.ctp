<div class="posts form">
<?php echo $this->Form->create('Post');?>
	<fieldset>
 		<legend><?php __('You Add Post'); ?></legend>
	<?php
		echo $this->Form->input('text');
		echo $this->Form->input('keyword');
		echo $this->Form->input('delflg');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Posts', true), array('action' => 'index'));?></li>
	</ul>
</div>