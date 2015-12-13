
<!-- テンプレート -->
<div class="container-fluid">
 <?php echo $this->element('header');?>
	<?php echo $this->element('sidenav');?>
	<!-- メインコンテンツここから -->
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10" >
		<!-- テンプレートおわり -->

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">課題内容</div>
			</div>
			<div class="panel-body">
				<dl>

					<dt><?php echo __('タイトル'); ?></dt>
					<dd>
							<?php echo h($assignment['Assignment']['title']); ?>
							&nbsp;
						</dd>
					<dt><?php echo __('課題内容'); ?></dt>
					<dd>
							<?php echo h($assignment['Assignment']['body']); ?>
							&nbsp;
						</dd>
					<dt><?php echo __('提出期限'); ?></dt>
					<dd>
							<?php echo h($assignment['Assignment']['expire']); ?>
							&nbsp;
						</dd>

					<dt><?php echo __('作成日時'); ?></dt>
					<dd>
							<?php echo h($assignment['Assignment']['created']); ?>
							&nbsp;
						</dd>
					<dt><?php echo __('更新日時'); ?></dt>
					<dd>
							<?php echo h($assignment['Assignment']['modified']); ?>
							&nbsp;
						</dd>
				</dl>

			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">操作</div>
				<div class="panel-body">
					<ul>
						<li><?php echo $this->Html->link(__('一覧へ戻る'), array('action' => 'lists', $assignment['Assignment']['subject_id'])); ?> </li>

					</ul>
				</div>
			</div>
		</div>
	</div>
</div>