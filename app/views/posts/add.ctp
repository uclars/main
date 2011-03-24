<h1>Add Post</h1>
<?php
echo $form->create('Post');
echo $form->input('text');
echo $form->input('keyword', array('rows' => '3'));
echo $form->end('Save Post');
?>
