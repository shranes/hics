<!-- file: /app/View/Elements/header.ctp -->

<?php echo $this->Html->css('sidenav.css');?>

<div id="sidenav">
	<div class="row" id="sidenav-row">
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">

			<!-- 4列をサイドメニューに割り当て -->
			<div class="well">
				<ul class="nav nav-sidebar">
					<li>
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="panel-title">アカウント情報</div>
							</div>
							<div class="panel-body">
								<ul class="list-unstyled">
									<li><?php echo __('ユーザー名'); ?>: <?php echo AuthComponent::user ( 'userlname' ).' '.AuthComponent::user ( 'userfname' );; ?>

									</li>

									<li><?php echo __('クラス名'); ?>: <?php echo h($user['Homeroom']['homeroom_name']); ?>

									</li>

									<li><?php echo __('担任教師'); ?>: <?php echo h($user['Teacher']['userlname'].' '.$user['Teacher']['userfname']);?>

									</li>
								</ul>


							</div>
						</div>
					</li>

					<li><?php echo $this->Html->link($this->Html->tag ( 'span', '', array (
							'class' => 'glyphicon glyphicon-th-list'
					) ) . ' ' . 'トピック'
							, array('controller' => 'topics', 'action' => 'common'),
							array (
								'escape' => false,
								'class' => 'btn btn-default',
								'role' => 'button'
						));?>
					</li>
					<li><?php echo $this->Html->link($this->Html->tag ( 'span', '', array (
							'class' => 'glyphicon glyphicon-file'
					) ) . ' ' . 'ファイル'
							, array('teacher' => false, 'controller' => 'files', 'action' => 'filelist'),
							array (
								'escape' => false,
								'class' => 'btn btn-default',
								'role' => 'button'
						));?>
					</li>
					<li><?php echo $this->Html->link($this->Html->tag ( 'span', '', array (
							'class' => 'glyphicon glyphicon-book'
					) ) . ' ' . '課　　題'
							, array('controller' => 'subjects', 'action' => 'index'),array (
								'escape' => false,
								'class' => 'btn btn-default',
								'role' => 'button'
						)
					);?></li>
				</ul>
			</div>
		</div>