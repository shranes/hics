<!-- File:View/assignments/lists.ctp -->

<?php echo $this->element('header');?>

<!-- テンプレート -->
<div class="container-fluid">
	<?php echo $this->element('sidenav');?>
	<!-- メインコンテンツここから -->
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10" >
		<!-- テンプレートおわり -->

		<table class="table table-striped table-bordered table-hover table-condensed">
			<tr>
				<th>Id</th>
				<th>ファイル</th>
				<th>提出課題一覧</th>
				<th>Title</th>
				<th>課題提出</th>
				<th>Created</th>
			</tr>

			<!--  ここから、$assignments配列をループして投稿記事の情報を表示 -->

			<?php foreach ($assignments as $assignment):	?>
			<tr>
				<td><?php echo $assignment['Assignment']['id'];?></td>
				<td><?php

				if (empty ( $assignment ['File'] )) {
					echo ' ';
				} else {
					echo $assignment ['File'] ['0'] ['attachment'];
				}
				?> </td>
				<td>
				<?php  echo $this->Html->link('提出済みファイル', array('controller' => 'reports', 'action' => 'index', $assignment['Assignment']['id']));?>
				</td>

				<td>
					<?php

				echo $this->Html->link ( $assignment ['Assignment'] ['title'], array (
						'controller' => 'assignments',
						'action' => 'view',
						$assignment ['Assignment'] ['id']
				) );
				?>
				</td>
				<td>
				<?php echo $this->Html->link('提出', array('controller' => 'reports', 'action' => 'add' ,$assignment['Assignment']['id'])); ?>
				</td>
				<td><?php echo $assignment['Assignment']['created'];?> </td>
			</tr>
			<?php endforeach;?>
			<?php unset($assignment);?>

		</table>
		<p><?php echo $this->Html->link('科目一覧', array('controller' => 'Subjects', 'action' => 'index'));?></p>

	</div>
</div>