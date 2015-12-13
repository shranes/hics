<?php echo $this->element('header');?>


<!-- テンプレート -->
<div class="container-fluid">
	<?php echo $this->element('teacher_sidenav');?>
	<!-- メインコンテンツここから -->
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10" >
		<!-- テンプレートおわり -->
		<div class="container-fluid">


<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('パスワードの変更'); ?></legend>
	<?php
		echo $this->Form->input('User.id');
		echo $this->Form->input('User.old_password', array('type'=> 'password', 'label' => '現在のパスワード'));
		echo $this->Form->input('User.password', array('label' => 'パスワード'));
	?>
	</fieldset>
<?php echo $this->Form->button(__('リセット'), array('type' => 'reset'));?>
<?php echo $this->Form->end(__('変更')); ?>
</div>

</div>
</div>
