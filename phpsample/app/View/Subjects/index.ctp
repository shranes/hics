<?php echo $this->element('header');?>




<!-- テンプレート -->
<div class="container-fluid">
	<?php echo $this->element('sidenav');?>
	<!-- メインコンテンツここから -->
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10">
	<!-- テンプレートおわり -->

		<h2><?php echo __('科目一覧'); ?></h2>
		<table class="table table-striped table-bordered table-hover table-condensed">
		<thead>
		<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>
				<th><?php echo $this->Paginator->sort('title'); ?></th>
				<th class="hidden-xs hidden-sm"><?php echo $this->Paginator->sort('body'); ?></th>
				<th class="hidden-xs hidden-sm"><?php echo $this->Paginator->sort('created'); ?></th>
				<th><?php echo $this->Paginator->sort('modified'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($subjects as $subject): ?>
		<tr>
			<td><?php echo h($subject['Subject']['id']); ?>&nbsp;</td>
			<td><?php echo $this->Html->link($subject['Subject']['title'], array('controller' => 'assignments', 'action' => 'lists', $subject['Subject']['id'])); ?>&nbsp;</td>
			<td class="hidden-xs hidden-sm"><?php echo h($subject['Subject']['body']); ?>&nbsp;</td>
			<td class="hidden-xs hidden-sm"><?php echo h($subject['Subject']['created']); ?>&nbsp;</td>
			<td><?php echo h($subject['Subject']['modified']); ?>&nbsp;</td>
			<td>
				<?php echo $this->Html->link(__('View'), array('action' => 'view', $subject['Subject']['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $subject['Subject']['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $subject['Subject']['id']), array(), __('Are you sure you want to delete # %s?', $subject['Subject']['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
		</tbody>
		</table>
		<p>
		<?php
		echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
		));
		?>	</p>
		<div class="paging">
		<?php
			echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
			echo $this->Paginator->numbers(array('separator' => ''));
			echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
		?>
		</div>
	</div>
</div>
<!--
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Subject'), array('action' => 'add')); ?></li>
	</ul>
</div>
-->