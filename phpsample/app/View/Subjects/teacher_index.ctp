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
					<h2>
						<?php echo __('科目一覧'); ?>
					</h2>
					<table
						class="table table-striped table-bordered table-hover table-condensed">
						<thead>
							<tr>

								<th><?php echo $this->Paginator->sort('title', '科目名'); ?></th>
								<th><?php echo $this->Paginator->sort('body', '内容'); ?></th>
								<th><?php echo $this->Paginator->sort('Homeroom.homeroom_name', 'ホームルーム'); ?>
								</th>
								<th><?php echo $this->Paginator->sort('created', '登録日時'); ?></th>
								<th class="actions"><?php echo __('操作'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($subjects as $subject): ?>
							<tr>

								<td><?php echo $this->Html->link($subject['Subject']['title'], array('controller' => 'assignments' , 'action' => 'lists', $subject['Subject']['id'])); ?>&nbsp;</td>
								<td><?php echo h($subject['Subject']['body']); ?>&nbsp;</td>
								<td><?php echo h($subject['Homeroom']['homeroom_name']); ?>&nbsp;</td>
								<td><?php echo h($subject['Subject']['created']); ?>&nbsp;</td>

								<td><?php echo $this->Form->postLink(__('download'),array('action'=> 'download', $subject['Subject']['id'])); ?>
									<?php echo $this->Html->link(__('View'), array('action' => 'view', $subject['Subject']['id'])); ?>
									<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $subject['Subject']['id'])); ?>
									<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $subject['Subject']['id']), array(), __(' 「%s」を本当に削除しますか?', $subject['Subject']['title'])); ?>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>

					<div>
						<?php echo $this->element('pagination')?>
					</div>

				</div>
				<div class="actions">
					<h3>
						<?php echo __('Actions'); ?>
					</h3>
					<ul>
						<li><?php echo $this->Html->link(__('New Subject'), array('action' => 'add')); ?>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
