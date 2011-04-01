<div class="users form">
<?php echo $this->Form->create('User');?>
  <fieldset>
     <legend><?php __('Add User'); ?></legend>
  <?php    echo $this->Form->input('username');
    echo $this->Form->input('email');
    echo $this->Form->input('password_new'); 
    echo $this->Form->input('password_chk');  ?>
  </fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div> 
