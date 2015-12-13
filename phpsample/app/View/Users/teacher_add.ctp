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
		<legend><?php echo __('生徒の登録'); ?></legend>
	<?php
		echo $this->Form->input('homeroom_id',array('type' => 'hidden' , 'value' => AuthComponent::user('homeroom_id')));
		echo $this->Form->input('teacher_id', array('type' => 'hidden', 'value' => AuthComponent::user('id')));
		echo $this->Form->input('username', array('label' => '学籍番号'));
		echo $this->Form->input('userlname',array('label' => '苗字'));
		echo $this->Form->input('userfname',array('label' => '名前'));
		echo $this->Form->input('password', array('label' => 'パスワード'));
		// トピックスも作成する
		echo $this->Form->create('Topic');
		echo $this->Form->input('Topic.range_role_id', array('type' => 'hidden', 'value' => '3'));
		echo $this->Form->input('Topic.homeroom_id' , array('type' => 'hidden','value' => AuthComponent::user('homeroom_id')));
		// 名前についてはコントローラで学籍番号を設定する
	?>
	</fieldset>
<?php echo $this->Form->end(__('登録')); ?>
</div>


</div>
</div>
