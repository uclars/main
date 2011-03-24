<?php
//### CREATE 2010/06/20 Pyon ###
	$this->layout = 'home';
	$this->pageTitle = '';
	$paginator->options(array('url' => $this->passedArgs));
?>
<?php if (isset($auth)): ?>
<div class="articles form">
	<?php echo $form->create(null, array('url' => array('controller' => 'articles', 'action' => 'add', '?' => array('redirect' => 'home'))))."\n"; ?>
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
	<h2>最近の投稿</h2>
	<p>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th width="10%"><?php echo $paginator->sort('日時', 'created'); ?></th>
			<th width="20%"><?php echo $paginator->sort('名前', 'name'); ?></th>
			<th width="50%"><?php echo $paginator->sort('本文', 'body'); ?></th>
			<th width="10%"><?php echo $paginator->sort('コメント数', 'CommentArticle.Count'); ?></th>
			<th width="10%" class="actions">&nbsp;</th>
		</tr>
<?php if (count($datas) == 0): ?>
		<tr>
			<td colspan="5" class="notfound">
				Not found</td>
		</tr>
<?php else: ?>
<?php $i = 0; ?>
<?php foreach ($datas as $data): ?>
		<tr<?php echo (($i++ % 2 == 0) ? ' class="altrow"' : ''); ?>>
			<td class="date"><?php echo ((strcmp($data['Article']['created'], '') != 0) ? h($data['Article']['created']) : '&nbsp;'); ?></td>
			<td><?php echo $html->link($data['User']['name'], array('controller' => 'articles', 'action' => 'index', 'id' => $data['Article']['user_id'])); ?></td>
			<td><?php echo $html->link($data['Article']['body'], array('controller' => 'comments', 'action' => 'index', 'id' => $data['Article']['id'])); ?></td>
			<td class="numbers"><?php echo number_format($data['CommentArticle']['Count']); ?></td>
			<td class="actions"><?php echo ((isset($auth)) && ($data['Article']['user_id'] == $auth['User']['id'])) ? $html->link('編集', array('controller' => 'articles', 'action' => 'edit', 'id' => $data['Article']['id'], '?' => array('redirect' => 'home'))).'<br>'.$html->link('削除', array('controller' => 'articles', 'action' => 'delete', 'id' => $data['Article']['id'], '?' => array('redirect' => 'home'))) : '&nbsp;'; ?></td>
		</tr>
<?php endforeach; ?>
<?php endif; ?>
	</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< 前へ', array(), null, array('class' => 'disabled')).' | '.$paginator->numbers().' | '.$paginator->next('次へ >>', array(), null, array('class' => 'disabled'))."\n"; ?>
</div>
<?php if (isset($auth)): ?>
<div class="actions">
	<ul>
		<li><?php echo $html->link('新規投稿', array('controller' => 'articles', 'action' => 'add', '?' => array('redirect' => 'home'))); ?></li>
		<li><?php echo $html->link('投稿一覧', array('controller' => 'articles', 'action' => 'index', 'id' => $auth['User']['id'])); ?></li>
		<li><?php echo $html->link('ユーザ一覧', array('controller' => 'users', 'action' => 'index')); ?></li>
		<li><?php echo $html->link('登録内容変更', array('controller' => 'users', 'action' => 'edit')); ?></li>
		<li><?php echo $html->link('退会', array('controller' => 'users', 'action' => 'delete')); ?></li>
	</ul>
</div>
<?php endif; ?>