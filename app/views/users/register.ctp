<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
		<legend><?php __('NickName'); ?></legend>
		<?php
		$nname = $this->Session->read('nick_name');
		if(!empty($nname)){
			echo $nname." is already taken <br />";
		}
		echo $this->Form->input('username',array('label'=>'NickName'));
		$this->Session->delete('nick_name');
		?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true)); ?>
</div>


<?php
echo $this->Session->read('nick_name');
echo "<br /><BR />";
echo "<br /><BR />";



$me_array = $this->Session->read('Auth.User');
$me = $me_array['id'];


/*
$tm = in_array(3,$follower_list);
echo "<PRE>";
var_dump($tm);
echo "</PRE>";
*/

?>

