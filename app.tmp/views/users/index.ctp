<?php
//### CREATE 2010/06/20 Pyon ###
	$this->pageTitle = 'ユーザ一覧';
	$paginator->options(array('url' => $this->passedArgs));
?>
<div class="users index">
	<h2><?php echo $this->pageTitle; ?></h2>
	<p>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th width="20%"><?php echo $paginator->sort('日時', 'created'); ?></th>
			<th width="60%"><?php echo $paginator->sort('名前', 'name'); ?></th>
			<th width="10%"><?php echo $paginator->sort('投稿数', 'ArticleUser.Count'); ?></th>
			<th width="10%"><?php echo $paginator->sort('コメント数', 'CommentUser.Count'); ?></th>
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
			<td><?php echo ((strcmp($data['User']['created'], '') != 0) ? h($data['User']['created']) : '&nbsp;'); ?></td>
			<td><?php echo $html->link($data['User']['name'], array('controller' => 'articles', 'action' => 'index', $data['User']['id'])); ?></td>
			<td class="numbers"><?php echo number_format($data['ArticleUser']['Count']); ?></td>
			<td class="numbers"><?php echo number_format($data['CommentUser']['Count']); ?></td>
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
	</ul>
</div>