<?php echo $this->element('header');?>

<!-- テンプレート -->
<div class="container-fluid">
	<?php echo $this->element('sidenav');?>
	<!-- メインコンテンツここから -->
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10" >
		<!-- テンプレートおわり -->

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title"><?php echo __('アカウント情報'); ?></div>
			</div>
			<div class="panel-body">
				<dl class="dl-horizontal">
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
					<dt><?php echo __('担任教師'); ?></dt>
					<dd>
			<?php echo h($user['Teacher']['userlname'].' '.$user['Teacher']['userfname']);?>
			&nbsp;
		</dd>
					<dt><?php echo __('更新日'); ?></dt>
					<dd>
			<?php echo h($user['User']['modified']); ?>
			&nbsp;
		</dd>
				</dl>

			</div>
			<div class="panel-footer"></div>
		</div>
	</div>
</div>
<div class="actions">
<?php echo $this->Html->link('登録情報変更', array ('controller' => 'users', 'action' => 'edit'));?>
</div>
