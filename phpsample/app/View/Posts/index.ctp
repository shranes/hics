<!-- File: /app/View/Posts/index.ctp	-->


<?php
// ヘッダー表示
echo $this->element ( 'header' );
?>
<!-- テンプレート -->
<div class="container-fluid">
	<?php echo $this->element('sidenav');?>
	<!-- メインコンテンツここから -->
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10">
		<!-- テンプレートおわり -->
		<div class="container-fluid">
			<div class="well">
				新着情報
				<div>
					<table
						class="table table-striped table-bordered table-hover table-condensed">
						<thead>
							<tr>
								<th>タイトル</th>
								<th>更新日時</th>
							</tr>
							<?php foreach ($n_posts as $n_post):?>
							<tr class="info">
								<td><?php echo h($n_post['Post']['id']); ?>&nbsp;</td>
								<td><?php
								echo $this->Html->link ( $n_post ['Post'] ['title'], array (
						'controller' => 'posts',
						'action' => 'view',
						$n_post ['Post'] ['id']
							) );
							?>
								</td>

								<td><?php echo $n_post['Post']['modified'];?>
								</td>
							</tr>
							<?php endforeach;?>
							<?php unset($n_posts);?>

					</table>
				</div>
			</div>


			<div class="well">課題情報</div>
		</div>

	</div>
</div>
