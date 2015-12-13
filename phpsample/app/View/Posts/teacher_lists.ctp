<!-- File:View/Posts/lists.ctp -->

<?php echo $this->element('header');?>



<!-- テンプレート -->
<div class="container-fluid">
	<?php echo $this->element('teacher_sidenav');?>
	<!-- メインコンテンツここから -->
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10">
		<!-- テンプレートおわり -->

		<div class="container-fluid">
			<div class="panel panel-default">
				<div class="panel-body">
				<h2>連絡一覧</h2>
					<?php

					echo $this->Html->link ( '記事を投稿', array (
							'controller' => 'posts',
							'action' => 'add',
							$topic_id
					) )?>
					<table
						class="table table-striped table-bordered table-hover table-condensed">
						<thead>
							<tr>
								<th><?php echo $this->Paginator->sort('id' , '記事ID');?></th>
								<th><?php echo $this->Paginator->sort('user', '作成者'); ?></th>
								<th><?php echo $this->Paginator->sort('file', '添付ファイル'); ?></th>
								<th><?php echo $this->Paginator->sort('title', 'タイトル'); ?></th>
								<th><?php echo '削除' ?></th>
								<th><?php echo '編集'; ?></th>
								<th><?php echo $this->Paginator->sort('created' , '作成日時'); ?></th>
							</tr>
						</thead>
						<!--  ここから、$posts配列をループして投稿記事の情報を表示 -->

						<?php foreach ($posts as $post):	?>
						<tr>
							<td><?php echo $post['Post']['id'];?></td>
							<td><?php

							echo $post ['User'] ['userlname'];
							echo $post ['User'] ['userfname']?></td>
							<td><?php

							if (empty ( $post ['File'] )) {
					echo ' ';
				} else {
					echo $post ['File'] ['0'] ['attachment'];
				}
				?>
							</td>
							<td><?php

							echo $this->Html->link ( $post ['Post'] ['title'], array (
						'controller' => 'posts',
						'action' => 'view',
						$post ['Post'] ['id']
				) );
				?>
							</td>
							<td>
								<!-- postLinkを使いjavascriptでPOSTリクエストのリンクを作成する --> <?php

								echo $this->Form->postLink ( '削除', array (
						'action' => 'delete',
						$post ['Post'] ['id']
				), array (
						'confirm' => '本当にいいですか？'
				) );
				?>

							<td><?php echo $this->Html->link('編集', array('action'=>'edit', $post['Post']['id']));?>
							</td>

							<td><?php echo $post['Post']['created'];?>
							</td>
						</tr>
						<?php endforeach;?>
						<?php unset($post);?>

					</table>


					<div>
						<?php echo $this->element('pagination')?>
					</div>


					<p>
						<?php echo $this->Html->link('トピック一覧', array('controller' => 'Topics', 'action' => 'common'));?>
					</p>
				</div>
			</div>
		</div>

	</div>
</div>
