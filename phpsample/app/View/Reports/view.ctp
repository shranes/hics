<?php echo $this->element('header');?>

<!-- テンプレート -->
<div class="container-fluid">
	<?php echo $this->element('sidenav');?>
	<!-- メインコンテンツここから -->
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10" >
		<!-- テンプレートおわり -->
		<div class="container-fluid">

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title"><?php echo __('提出済み課題'); ?></div>
			</div>
			<div class="panel-body">
				<dl>
					<dt><?php echo __('Id'); ?></dt>
					<dd>
			<?php echo h($report['Report']['id']); ?>
			&nbsp;
		</dd>
					<dt><?php echo __('Assignment Id'); ?></dt>
					<dd>
			<?php echo h($report['Report']['assignment_id']); ?>
			&nbsp;
		</dd>
					<dt><?php echo __('User Id'); ?></dt>
					<dd>
			<?php echo h($report['Report']['user_id']); ?>
			&nbsp;
		</dd>
					<dt><?php echo __('Comment'); ?></dt>
					<dd>
			<?php echo h($report['Report']['comment']); ?>
			&nbsp;
		</dd>
					<dt><?php echo __('Created'); ?></dt>
					<dd>
			<?php echo h($report['Report']['created']); ?>
			&nbsp;
		</dd>
					<dt><?php echo __('Modified'); ?></dt>
					<dd>
			<?php echo h($report['Report']['modified']); ?>
			&nbsp;
		</dd>
				</dl>
			</div>

	</div>
	</div>


	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-title">添付ファイル</div>
			<div class="panel-body">
				<?php
				$i = 0;
				foreach ( $report ['File'] as $file ) :

					// echo WWW_ROOT.'files'.DS.'posts'.DS.$post['File'][$i]['dir'].DS.$post['File'][$i]['attachment'];
					echo $this->Html->link ( $report ['File'] [$i] ['attachment'], array (
							'teacher' => false,
							'controller' => 'Files',
							'action' => 'download',
							$report ['File'] [$i] ['id']
					) );
					echo '<br>';
					// 削除ボタン
					$i ++;
				endforeach
				;
				?>
				</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-title"><?php echo __('操作一覧'); ?></div>
			<div class="panel-body">

		<ul>
			<li><?php echo $this->Html->link(__('編集'), array('action' => 'edit', $report['Report']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('削除'), array('action' => 'delete', $report['Report']['id']), array(), __('Are you sure you want to delete # %s?', $report['Report']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('レポート一覧'), array('action' => 'index', $report['Report']['assignment_id'])); ?> </li>
			<li><?php echo $this->Html->link(__('新しいレポート'), array('action' => 'add')); ?> </li>
		</ul>
		</div>
		</div>
	</div>