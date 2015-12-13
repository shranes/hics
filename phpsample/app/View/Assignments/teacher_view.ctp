<?php echo $this->element('header');?>
<!-- テンプレート -->
<div class="container-fluid">
	<?php echo $this->element('teacher_sidenav');?>
	<!-- メインコンテンツここから -->
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10" >
		<!-- テンプレートおわり -->
		<div class="container-fluid">
<h2><?php echo __('Assignment'); ?></h2>
	<dl>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($assignment['Assignment']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Body'); ?></dt>
		<dd>
			<?php echo h($assignment['Assignment']['body']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('期限'); ?></dt>
		<dd>
			<?php echo h($assignment['Assignment']['expire']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($assignment['Assignment']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($assignment['Assignment']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
</div>


<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Assignment'), array('action' => 'edit', $assignment['Assignment']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Assignment'), array('action' => 'delete', $assignment['Assignment']['id']), array(), __('Are you sure you want to delete # %s?', $assignment['Assignment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('課題一覧へ戻る'), array('action' => 'lists', $assignment['Assignment']['subject_id'])); ?> </li>
		<li><?php echo $this->Html->link(__('New Assignment'), array('action' => 'add')); ?> </li>
	</ul>
</div>

</div>

