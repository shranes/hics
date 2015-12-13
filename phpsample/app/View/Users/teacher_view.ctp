<?php echo $this->element('header');?>



<!-- テンプレート -->
<div class="container-fluid">
	<?php echo $this->element('teacher_sidenav');?>
	<!-- メインコンテンツここから -->
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10" >
		<!-- テンプレートおわり -->
		<div class="container-fluid">
<h2><?php echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('アカウント名'); ?></dt>
		<dd>
			<?php echo h($user['User']['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('グループ'); ?></dt>
		<dd>
			<?php echo h($user['Group']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('ユーザ名'); ?></dt>
		<dd>
			<?php echo h($user['User']['userlname'].' '.$user['User']['userfname']);?>
		</dd>
		<dt><?php echo __('クラス名'); ?></dt>
		<dd>
			<?php echo h($user['Homeroom']['homeroom_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('作成日'); ?></dt>
		<dd>
			<?php echo h($user['User']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('更新日'); ?></dt>
		<dd>
			<?php echo h($user['User']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">

<p><?php echo $this->Html->link('登録情報変更', array ('controller' => 'users', 'action' => 'teacher_edit'));?>
</p>
<p>
<?php echo $this->Html->link('パスワード変更', array('controller' => 'users', 'action' => 'teacher_password'));?>
</p>
</div>


</div>
</div>
