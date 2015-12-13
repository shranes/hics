<!--  app/View/Users/login.ctp -->

<?php echo $this->Html->css( 'login.css');?>

<?php echo $this->element('header');?>


<div class="container-fluid" id="login">
<div class="row">
	<div class="col-xs-8 col-xs-offset-2 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-2 col-lg-offset-5">
		<div class="well">

			<!--
	labe:フォーム名
	form-control:フォームパーツ
	form-group:labelとform-groupの配置のため

	-->

			<div class="form-group"></div>
				<?php echo $this->Session->flash('auth');?>
				<?php echo $this->Form->create('User');?>
				<div class="form-group">
							<?php

							echo $this->Form->input ( 'username', array (
									'class' => 'form-control',
									'label' => 'ユーザ名ID'
							) );
							?>
				<div class="form-group">
							<?php
							echo $this->Form->input ( 'password', array (
									'class' => 'form-control',
									'label' => 'パスワード'
							) );
							?>
							</div>
				<!--
				<div class="form-group">
			    <label for="exampleInputPassword1">パスワード</label>
			    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="パスワード">
			    -->
			</div>

				<?php echo $this->Form->end (array('label'=> 'ログイン', 'class' => 'btn btn-primary'));?>

				<?php echo $this->Html->link('ホームへ戻る', array('controller' => 'Posts', 'action'=>'index'))?>
		</div>
		<!-- flash()で好きなところでsetFlashを受け取れる -->
		<div><?php echo $this->Session->flash(); ?></div>
	</div>
	</div>
</div>