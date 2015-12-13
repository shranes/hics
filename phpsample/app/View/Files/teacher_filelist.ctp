
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
				<h2>投稿ファイル一覧</h2>
					<table
						class="table table-striped table-bordered table-hover table-condensed">
						<thead>
							<tr>
								<th><?php echo $this->Paginator->sort('id', 'ファイル名');?></th>
								<th><?php echo h('削除')?></th>
								<th><?php echo h('ダウンロード')?></th>
								<th><?php echo $this->Paginator->sort('id','アップロード日時')?></th>
							</tr>
						</thead>

						<!--  ここから、$posts配列をループして投稿記事の情報を表示 -->

						<?php foreach ($files as $file):	?>

						<tr>
							<td><?php echo $file['Attachment']['attachment'];?></td>
							<td>
								<!-- postLinkを使いjavascriptでPOSTリクエストのリンクを作成する --> <?php

								echo $this->Form->postLink ( '削除', array (
							'action' => 'delete',
							$file ['Attachment'] ['id']
					), array (
							'confirm' => '本当にいいですか？'
					) );
					?>
							</td>
							<td><?php

							echo $this->Html->link ( $file ['Attachment'] ['attachment'], array (
							'controller' => 'Files',
							'action' => 'download',
							$file ['Attachment'] ['id']
					) );
					?>
							</td>

							<td><?php echo $file['Attachment']['created'];?>
							</td>
						</tr>


						<?php endforeach;?>
						<?php unset($file);?>



					</table>

					<div>
						<?php echo $this->element('pagination');?>
					</div>

				</div>
			</div>
		</div>
</div>
