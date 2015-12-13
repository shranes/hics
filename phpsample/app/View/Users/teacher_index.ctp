
<?php echo $this->element('header');?>
<!-- テンプレート -->
<div class="container-fluid">
	<?php echo $this->element('teacher_sidenav');?>
	<!-- メインコンテンツここから -->
	<!-- テンプレートおわり -->
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10">
		<div class="container-fluid">
			<div class="panel panel-default">
				<div class="panel-body">
					<h2>
						<?php echo __('生徒一覧'); ?>
					</h2>
					<table
						class="table table-striped table-bordered table-hover table-condensed">
						<thead>
							<tr>
								<th><?php echo $this->Paginator->sort('username', '学籍番号');?>

								<th><?php echo $this->Paginator->sort('userlname', '氏名')?>

								<th><?php echo $this->Paginator->sort('Group.name', '識別'); ?></th>
								<th><?php echo $this->Paginator->sort('created', '登録日'); ?></th>
								<th><?php echo $this->Paginator->sort('modified', '更新日'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($users as $user): ?>
							<tr>
								<td><?php echo h($user['User']['username']); ?>&nbsp;</td>
								<td><?php echo $this->Html->link(__(h($user['User']['userlname'].' '.$user['User']['userfname'])),
								array('action' => 'teacher_info', $user['User']['id'])); ?>

								<td><?php echo h($user['Group']['name']); ?>
								</td>
								<td><?php echo h($user['User']['created']); ?>&nbsp;</td>
								<td><?php echo h($user['User']['modified']); ?>&nbsp;</td>
								<?php //echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id'])); ?>
								<?php //echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $user['User']['id']), array(), __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>

					<!-- ページネイト -->
					<div>
						<?php echo $this->element('pagination');?>
					</div>
				</div>



				<div class="actions">
					<h3>
						<?php echo __('学生登録'); ?>
					</h3>
					<ul>
						<li><?php echo $this->Html->link(__('学生登録'), array('action' => 'add')); ?>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
