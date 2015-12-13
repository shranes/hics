<?php echo $this->element('header');?>

<!-- テンプレート -->
<div class="container-fluid">
	<?php echo $this->element('teacher_sidenav');?>
	<!-- メインコンテンツここから -->
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10" >
		<!-- テンプレートおわり -->
		<div class="container-fluid">

<h2><?php echo __('Report'); ?></h2>
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
	<p>
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
?></p>
</div>
</div>
</div>

<!--
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Report'), array('action' => 'edit', $report['Report']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Report'), array('action' => 'delete', $report['Report']['id']), array(), __('Are you sure you want to delete # %s?', $report['Report']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Reports'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Report'), array('action' => 'add')); ?> </li>
	</ul>
</div>
-->
