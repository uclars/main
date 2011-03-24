    <div class="addButton">
        <?php echo $html->link('つぶやく', '/posts/add').PHP_EOL; ?>
    </div>
<?php foreach ($posts as $post): ?>
    <div class="messageArea">
        <span class="writer"><?php echo h("takeru-c"); ?></span>
        <span class="message"><?php echo h($post['Post']['text']); ?></span>
        <span class="datetime"><?php echo date("Y/m/d H:i", strtotime($post['Post']['created'])); ?></span>
        <span class="actions">
        <?php echo $html->link('View','/posts/view/' . $post['Post']['id']).PHP_EOL ?>
        <?php echo $html->link('Edit','/posts/edit/' . $post['Post']['id']).PHP_EOL ?>
        <?php echo $html->link('Delete','/posts/delete/' . $post['Post']['id'], null, 'Are you sure you want to delete id ' . $post['Post']['id']).PHP_EOL ?>
        </span>
    </div>
