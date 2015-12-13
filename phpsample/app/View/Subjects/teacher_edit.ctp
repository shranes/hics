
<?php echo $this->element('header')?>


<!-- テンプレート -->
<div class="container-fluid">
	<?php echo $this->element('teacher_sidenav');?>
	<!-- メインコンテンツここから -->
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10" >
		<!-- テンプレートおわり -->
		<div class="container-fluid">

<?php echo $this->Form->create('Subject'); ?>
	<fieldset>
		<legend><?php echo __('Teacher Edit Subject'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('body');
		echo $this->Form->input('homeroom_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Subject.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Subject.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Subjects'), array('action' => 'index')); ?></li>
	</ul>
</div>


</div>
</div>
