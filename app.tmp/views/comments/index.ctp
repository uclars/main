<?php
//### CREATE 2010/06/20 Pyon ###
	$this->pageTitle = '投稿詳細';
	$paginator->options(array('url' => $this->passedArgs));
?>
<div class="comments index">
	<h2>投稿詳細</h2>
	<p>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th width="10%">日時</th>
			<th width="20%">名前</th>
			<th width="60%">本文</th>
			<th width="10%" class="actions">&nbsp;</th>
		</tr>
		<tr class="altrow">
			<td class="date"><?php echo h($article['Article']['created']); ?></td>
			<td><?php echo $html->link($article['User']['name'], array('controller' => 'articles', 'action' => 'index', 'id' => $article['Article']['user_id'])); ?></td>
			<td><?php echo h($article['Article']['body']); ?></td>
			<td class="actions"><?php echo ((isset($auth)) && ($article['Article']['user_id'] == $auth['User']['id'])) ? $html->link('編集', array('controller' => 'articles', 'action' => 'edit', 'id' => $article['Article']['id'], '?' => array('redirect' => 'comments'))).'<br>'.$html->link('削除', array('controller' => 'articles', 'action' => 'delete', 'id' => $article['Article']['id'])) : '&nbsp;'; ?></td>
		</tr>
	</table>
	<h3>コメント</h3>
	<p>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th width="10%"><?php echo $paginator->sort('日時', 'created'); ?></th>
			<th width="20%"><?php echo $paginator->sort('名前', 'user_id'); ?></th>
			<th width="60%"><?php echo $paginator->sort('本文', 'body'); ?></th>
			<th width="10%" class="actions">&nbsp</th>
		</tr>
<?php if (count($datas) == 0): ?>
		<tr>
			<td colspan="4" class="notfound">
				Not found</td>
		</tr>
<?php else: ?>
<?php $i = 0; ?>
<?php foreach ($datas as $data): ?>
		<tr<?php echo (($i++ % 2 == 0) ? ' class="altrow"' : ''); ?>>
			<td class="date"><?php echo ((strcmp($data['Comment']['created'], '') != 0) ? h($data['Comment']['created']) : '&nbsp;'); ?></td>
			<td><?php echo $html->link($data['User']['name'], array('controller' => 'articles', 'action' => 'index', 'id' => $data['Comment']['user_id'])); ?></td>
			<td><?php echo h($data['Comment']['body']); ?></td>
			<td class="actions"><?php echo ((isset($auth)) && (($data['Comment']['user_id'] == $auth['User']['id']) || ($data['Article']['user_id'] == $auth['User']['id']))) ? $html->link('削除', array('action' => 'delete', 'id' => $data['Comment']['id'])) : '&nbsp;'; ?></td>
		</tr>
<?php endforeach; ?>
<?php endif; ?>
	</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< 前へ', array(), null, array('class' => 'disabled')).' | '.$paginator->numbers().' | '.$paginator->next('次へ >>', array(), null, array('class' => 'disabled'))."\n"; ?>
</div>
<?php if (isset($auth)): ?>
<div class="comments form">
	<?php echo $form->create(null, array('url' => array('action' => 'add', 'id' => $article['Article']['id'])))."\n"; ?>
		<fieldset>
			<legend>コメント投稿</legend>
			<?php echo $form->input('body', array('label' => '本文'))."\n"; ?>
		</fieldset>
		<div class="submit">
			<?php echo $form->input('Request.id', array('type' => 'hidden'))."\n"; ?>
			<?php echo $form->submit('確認', array('div' => false, 'name' => 'data[Check]')).'&nbsp;'.$form->submit('確認せずに送信', array('div' => false, 'name' => 'data[Next]'))."\n"; ?>
		</div>
	<?php echo $form->end()."\n"; ?>
</div>
<?php endif; ?>
<div class="actions">
	<ul>
		<li><?php echo $html->link('ホーム', '/'); ?></li>
<?php if (isset($auth)): ?>
		<li><?php echo $html->link('ユーザ一覧', array('controller' => 'users', 'action' => 'index')); ?></li>
		<li><?php echo $html->link('コメント投稿', array('action' => 'add', 'id' => $article['Article']['id'])); ?></li>
<?php endif; ?>
	</ul>
</div>