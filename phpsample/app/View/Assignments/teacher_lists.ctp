<!-- File:View/assignments/lists.ctp -->

<?php echo $this->element('header');?>

<!-- テンプレート -->
<div class="container-fluid">
	<?php echo $this->element('teacher_sidenav');?>
	<!-- メインコンテンツここから -->
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10">
		<!-- テンプレートおわり -->
<?php

echo $this->Html->link ( '課題を設定', array (
		'controller' => 'assignments',
		'action' => 'add',
		$subject_id
) )?>
<table
			class="table table-striped table-bordered table-hover table-condensed">
			<tr>
				<th class="hidden-xs hidden-sm"><?php echo $this->Paginator->sort('File.0.attachment', '添付ファイル');?></th>
				<th><?php echo $this->Paginator->sort('title', '課題名');?></th>
				<th><?php echo h('編集')?></th>
				<th><?php echo h('提出者一覧')?></th>
				<th><?php echo $this->Paginator->sort('created', '登録日時')?></th>
				<th><?php echo h('一括ダウンロード')?>
			</tr>

			<!--  ここから、$assignments配列をループして投稿記事の情報を表示 -->

			<?php foreach ($assignments as $assignment):?>

			<tr>
				<td class="hidden-xs hidden-sm"><?php
					if (empty ( $assignment ['File'] )) {
								echo ' ';
							} else {
								echo $assignment ['File'] ['0'] ['attachment'];
					};?></td>
				<td>
					<?php
					echo $this->Html->link ( $assignment ['Assignment'] ['title'], array (
							'controller' => 'assignments',
							'action' => 'view',
							$assignment ['Assignment'] ['id']
					) );?>
					</td>
				<!-- <td>
					<!-- assignmentLinkを使いjavascriptでassignmentリクエストのリンクを作成する
					<?php

// 					echo $this->Form->postLink ( '削除', array (
// 									'action' => 'delete',
// 									$assignment ['Assignment'] ['id']
// 							), array (
// 									'confirm' => '本当にいいですか？'
// 							) );
					?></td>-->
				<td>
					<?php echo $this->Html->link('編集', array('action'=>'edit', $assignment['Assignment']['id']));?>
				</td>
				<td>
					<?php echo $this->Html->link('提出者一覧' , array('controller' => 'reports', 'action' => 'index' , $assignment['Assignment']['id']));?>
				</td>
				<td><?php echo $assignment['Assignment']['created'];?> </td>
				<td>
				<?php echo $this->Form->postLink(__('download'),array('action'=> 'download', $assignment['Assignment']['id'])); ?>
				</td>
			</tr>
			<?php endforeach;?>
			<?php unset($assignment);?>
</table>

	</div>
</div>

<?php echo $this->Form->end('確定')?>
<p><?php echo $this->Html->link('科目一覧', array('controller' => 'Subjects', 'action' => 'index'));?></p>
