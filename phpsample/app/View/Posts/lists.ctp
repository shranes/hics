<!-- File:View/Posts/lists.ctp -->

<?php echo $this->element('header');?>

<!-- テンプレート -->
<div class="container-fluid">
	<?php echo $this->element('sidenav');?>
	<!-- メインコンテンツここから -->
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10">
		<!-- テンプレートおわり -->

		<div class="container-fluid">
			<table
				class="table table-striped table-bordered table-hover table-condensed">
				<thead>
					<tr>
						<th><?php echo $this->Paginator->sort('id');?></th>
						<th><?php echo $this->Paginator->sort('user'); ?></th>
						<th><?php echo $this->Paginator->sort('title'); ?></th>
						<th><?php echo $this->Paginator->sort('file'); ?></th>
						<th><?php echo $this->Paginator->sort('body'); ?></th>
						<th><?php echo $this->Paginator->sort('user_id'); ?></th>
						<th><?php echo $this->Paginator->sort('modified'); ?></th>
					</tr>
				</thead>
				<!--  ここから、$posts配列をループして投稿記事の情報を表示 -->
			<?php foreach ($posts as $post):	?>
			<tr>
					<td><?php echo h($post['Post']['id']); ?>&nbsp;</td>
					<td><?php
				echo h ( $post ['User'] ['userlname'] );
				echo h ( $post ['User'] ['userfname'] )?></td>
					<td>
						<?php
				echo $this->Html->link ( $post ['Post'] ['title'], array (
						'controller' => 'posts',
						'action' => 'view',
						$post ['Post'] ['id']
				) );
				?>
					</td>
					<td><?php
				if (empty ( $post ['File'] )) {
					echo h ( ' ' );
				} else {
					echo h ( $post ['File'] ['0'] ['attachment'] );
				}
				?>
					</td>
					<td>
						<!-- postLinkを使いjavascriptでPOSTリクエストのリンクを作成する -->
						<?php
				echo $this->Form->postLink ( '削除', array (
						'action' => 'delete',
						$post ['Post'] ['id']
				), array (
						'confirm' => '本当にいいですか？'
				) );
				?>
					<td>
						<?php echo $this->Html->link('編集', array('action'=>'edit', $post['Post']['id']));?>
					<td><?php echo $post['Post']['modified'];?> </td>
				</tr>
			<?php endforeach;?>
			<?php unset($post);?>
		</table>
		</div>
		<p><?php echo $this->Html->link('トピック一覧', array('controller' => 'Topics', 'action' => 'common'));?></p>
	</div>
</div>


