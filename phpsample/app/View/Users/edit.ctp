<?php echo $this->element('header');?>



<!-- テンプレート -->
<div class="container-fluid">
	<?php echo $this->element('sidenav');?>
	<!-- メインコンテンツここから -->
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10" >
		<!-- テンプレートおわり -->
		<div class="container-fluid">

<div class="users view"><?php echo $this->Form->create('User'); ?>
<fieldset>
	<legend><?php echo __('情報変更'); ?></legend>
	<?php
	echo $user['User']['username'];
	echo nl2br('<br>');
	echo $this->Form->input('User.id', array('type' => 'hidden', 'value' => $user['User']['id']));
	echo $this->Form->input('User.userlname', array('label' => '苗字','value' => $user['User']['userlname']));
	echo $this->Form->input('User.userfname', array('label' => '名前', 'value' => $user['User']['userfname']));
	echo $this->Form->input ( 'User.password', array('label' => 'パスワード'));

	?>
	</fieldset>
<?php echo $this->Form->end(__('変更')); ?>
</div>


</div>
</div>
</div>