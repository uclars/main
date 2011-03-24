<?php
//### CREATE 2010/06/20 Pyon ###
	$this->pageTitle = h($user['User']['name']).'さんの投稿一覧';
	$paginator->options(array('url' => $this->passedArgs));
?>
<?php if ((isset($auth)) && ($user['User']['id'] == $auth['User']['id'])): ?>
<div class="articles form">
	<?php echo $form->create(null, array('url' => array('action' => 'add')))."\n"; ?>
		<fieldset>
			<legend>新規投稿</legend>
			<?php echo $form->input('body', array('label' => '本文'))."\n"; ?>
		</fieldset>
		<div class="submit">
			<?php echo $form->input('Request.id', array('type' => 'hidden'))."\n"; ?>
			<?php echo $form->submit('確認', array('div' => false, 'name' => 'data[Check]')).'&nbsp;'.$form->submit('確認せずに送信', array('div' => false, 'name' => 'data[Next]'))."\n"; ?>
		</div>
	<?php echo $form->end()."\n"; ?>
</div>
<?php endif; ?>
<div class="articles index">
	<h2><?php echo $this->pageTitle; ?></h2>
	<p>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th width="10%"><?php echo $paginator->sort('日時', 'created'); ?></th>
			<th width="70%"><?php echo $paginator->sort('本文', 'body'); ?></th>
			<th width="10%"><?php echo $paginator->sort('コメント数', 'CommentArticle.Count'); ?></th>
			<th width="10%" class="actions">&nbsp;</th>
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
			<td class="date"><?php echo ((strcmp($data['Article']['created'], '') != 0) ? h($data['Article']['created']) : '&nbsp;'); ?></td>
			<td><?php echo $html->link($data['Article']['body'], array('controller' => 'comments', 'action' => 'index', 'id' => $data['Article']['id'])); ?></td>
			<td class="numbers"><?php echo number_format($data['CommentArticle']['Count']); ?></td>
			<td class="actions"><?php echo ((isset($auth)) && ($data['Article']['user_id'] == $auth['User']['id'])) ? $html->link('編集', array('action' => 'edit', 'id' => $data['Article']['id'])).'<br>'.$html->link('削除', array('action' => 'delete', 'id' => $data['Article']['id'])) : '&nbsp;'; ?></td>
		</tr>
<?php endforeach; ?>
<?php endif; ?>
	</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< 前へ', array(), null, array('class' => 'disabled')).' | '.$paginator->numbers().' | '.$paginator->next('次へ >>', array(), null, array('class' => 'disabled'))."\n"; ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link('ホーム', '/'); ?></li>
<?php if (isset($auth)): ?>
		<li><?php echo $html->link('ユーザ一覧', array('controller' => 'users', 'action' => 'index')); ?></li>
<?php if ($user['User']['id'] == $auth['User']['id']): ?>
		<li><?php echo $html->link('新規投稿', array('action' => 'add')); ?></li>
<?php endif; ?>
<?php endif; ?>
	</ul>
</div>