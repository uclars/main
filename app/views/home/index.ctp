<form action="<?php echo h($html->url('/posts/add')) ?>" method="post" style="margin-bottom:1em">
<p><?php echo $form->text('text') ?>
<?php echo $form->end('GO') ?></p>
</form>
<table>
<?php foreach($posts as $post) { ?>
<tr>
<td><?php echo h($post['Post']['id']); ?></td>
<td><?php echo h($post['Post']['text']); ?></td>
<td><?php echo h($post['Post']['created']); ?></td>
</tr>
<?php } ?>
</table>
