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
		<legend><?php echo __('Edit User'); ?></legend>
	<?php
		// モデル名.カラム名でモデルを指定して、コントローラーはdeep有効のsaveall()
		echo $this->Form->input('User.id');
		echo $this->Form->input('User.username');
		echo $this->Form->input('User.userlname' , array('label' => '苗字'));
		echo $this->Form->input('User.userfname' , array('label' => '名前'));
		echo $this->Form->input('Homeroom.id', array('type' => 'hidden' ));
		echo $this->Form->input('Homeroom.homeroom_name', array('label' => '担当クラス名'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('変更')); ?>
</div>

</div>
</div>

